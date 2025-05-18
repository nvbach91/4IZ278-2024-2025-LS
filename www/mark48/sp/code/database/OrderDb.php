<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Ticket.php';

/**
 * Order database model
 */
class OrderDb
{
    private $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get order by ID
     * @param int $id Order ID
     * @return Order|null Order object or null if not found
     */
    public function getOrderById($id)
    {
        $order = $this->db->fetch(
            "SELECT o.*, 
                    (SELECT COUNT(*) FROM sp_tickets t WHERE t.order_id = o.order_id) as ticket_count,
                    (SELECT SUM(sc.price) 
                     FROM sp_tickets t 
                     JOIN sp_seats s ON t.seat_id = s.id 
                     JOIN sp_seat_categories sc ON s.seat_category_id = sc.id 
                     WHERE t.order_id = o.order_id) as total_price,
                    (SELECT p.status FROM sp_payments p WHERE p.order_id = o.order_id ORDER BY p.paid_at DESC LIMIT 1) as payment_status
             FROM sp_orders o
             WHERE o.order_id = ?",
            [$id]
        );

        return $order ? new Order($order) : null;
    }

    /**
     * Get orders for user
     * @param int $userId User ID
     * @return array Order objects
     */
    public function getOrdersForUser($userId)
    {
        $orders = $this->db->fetchAll(
            "SELECT o.*, 
                    COUNT(t.id) as ticket_count, 
                    SUM(sc.price) as total_price,
                    (SELECT p.status FROM sp_payments p WHERE p.order_id = o.order_id ORDER BY p.paid_at DESC LIMIT 1) as payment_status
             FROM sp_orders o
             JOIN sp_tickets t ON o.order_id = t.order_id
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             WHERE o.user_id = ?
             GROUP BY o.order_id
             ORDER BY o.order_date DESC",
            [$userId]
        );

        $orderObjects = [];
        foreach ($orders as $order) {
            $orderObjects[] = new Order($order);
        }

        return $orderObjects;
    }

    /**
     * Get tickets for order
     * @param int $orderId Order ID
     * @return array Ticket objects
     */
    public function getTicketsForOrder($orderId)
    {
        $tickets = $this->db->fetchAll(
            "SELECT t.*, s.row_index, s.col_index, sc.name as category_name, sc.price,
                    e.title as event_title, e.start_datetime, e.location, e.id as event_id
             FROM sp_tickets t
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             JOIN sp_events e ON s.event_id = e.id
             WHERE t.order_id = ?
             ORDER BY s.row_index, s.col_index",
            [$orderId]
        );

        $ticketObjects = [];
        foreach ($tickets as $ticket) {
            $ticketObjects[] = new Ticket($ticket);
        }

        return $ticketObjects;
    }

    /**
     * Get ticket by ID
     * @param int $id Ticket ID
     * @return Ticket|null Ticket object or null if not found
     */
    public function getTicketById($id)
    {
        $ticket = $this->db->fetch(
            "SELECT t.*, s.row_index, s.col_index, sc.name as category_name, sc.price,
                    e.title as event_title, e.start_datetime, e.location, e.id as event_id
             FROM sp_tickets t
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             JOIN sp_events e ON s.event_id = e.id
             WHERE t.id = ?",
            [$id]
        );

        return $ticket ? new Ticket($ticket) : null;
    }

    /**
     * Create order
     * @param int $userId User ID
     * @param array $seatIds Array of seat IDs
     * @return int|false Order ID if successful, false otherwise
     */
    public function createOrder($userId, $seatIds)
    {
        try {
            $this->db->beginTransaction();

            // Create order
            $this->db->query(
                "INSERT INTO sp_orders (user_id, order_date) VALUES (?, NOW())",
                [$userId]
            );
            $orderId = $this->db->lastInsertId();

            // Create tickets
            foreach ($seatIds as $seatId) {
                $this->db->query(
                    "INSERT INTO sp_tickets (order_id, seat_id) VALUES (?, ?)",
                    [$orderId, $seatId]
                );

                // Update seat status
                $this->db->query(
                    "UPDATE sp_seats SET status = 'sold' WHERE id = ?",
                    [$seatId]
                );
            }

            $this->db->commit();
            return $orderId;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Update order status
     * @param Order $order Order object
     * @param string $status New status
     * @return bool True if successful, false otherwise
     */
    public function updateOrderStatus($order, $status)
    {
        try {
            $this->db->beginTransaction();

            // Update order status
            $this->db->query(
                "UPDATE sp_orders SET status = ? WHERE order_id = ?",
                [$status, $order->order_id]
            );

            // Add status history
            $this->db->query(
                "INSERT INTO sp_order_status_history (order_id, status, created_at)
                 VALUES (?, ?, NOW())",
                [$order->order_id, $status]
            );

            // If status is cancelled, release seats
            if ($status === 'cancelled') {
                $this->db->query(
                    "UPDATE sp_seats s
                     JOIN sp_tickets t ON s.id = t.seat_id
                     SET s.status = 'available'
                     WHERE t.order_id = ?",
                    [$order->order_id]
                );
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Create payment
     * @param int $order order_id
     * @param float $amount Payment amount
     * @param string $method Payment method
     * @return int|false Payment ID if successful, false otherwise
     */
    public function createPayment($order_id, $amount, $method)
    {
        try {
            $this->db->query(
                "INSERT INTO sp_payments (order_id, amount, payment_method, status, paid_at)
                 VALUES (?, ?, ?, 'completed', NOW())",
                [$order_id, $amount, $method]
            );

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Cancel order
     * @param Order $order Order object
     * @return bool True if successful, false otherwise
     */
    public function cancelOrder($order)
    {
        try {
            $this->db->beginTransaction();

            // Update order status
            $result = $this->updateOrderStatus($order, 'cancelled');
            if (!$result) {
                $this->db->rollback();
                return false;
            }

            // Release seats
            $this->db->query(
                "UPDATE sp_seats s
                 JOIN sp_tickets t ON s.id = t.seat_id
                 SET s.status = 'available'
                 WHERE t.order_id = ?",
                [$order->order_id]
            );

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Get all orders
     * @param int $limit Maximum number of orders to return
     * @param int $offset Number of orders to skip
     * @return array Order objects
     */
    public function getAllOrders($limit = 50, $offset = 0)
    {
        $orders = $this->db->fetchAll(
            "SELECT o.*, 
                    COUNT(t.id) as ticket_count, 
                    SUM(sc.price) as total_price,
                    (SELECT p.status FROM sp_payments p WHERE p.order_id = o.order_id ORDER BY p.paid_at DESC LIMIT 1) as payment_status
             FROM sp_orders o
             JOIN sp_tickets t ON o.order_id = t.order_id
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             GROUP BY o.order_id
             ORDER BY o.order_date DESC
             LIMIT ? OFFSET ?",
            [$limit, $offset]
        );

        $orderObjects = [];
        foreach ($orders as $order) {
            $orderObjects[] = new Order($order);
        }

        return $orderObjects;
    }

    /**
     * Count total orders
     * @return int Total number of orders
     */
    public function countOrders()
    {
        $result = $this->db->fetch("SELECT COUNT(*) as count FROM sp_orders");
        return (int)$result['count'];
    }

    /**
     * Calculate total sales
     * @return float Total sales amount
     */
    public function calculateTotalSales()
    {
        $result = $this->db->fetch(
            "SELECT SUM(sc.price) as total
             FROM sp_tickets t
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             JOIN sp_orders o ON t.order_id = o.order_id
             JOIN sp_payments p ON o.order_id = p.order_id
             WHERE p.status = 'completed'"
        );

        return (float)($result['total'] ?? 0);
    }

    /**
     * Get sales by event
     * @return array Array of event sales data
     */
    public function getSalesByEvent()
    {
        return $this->db->fetchAll(
            "SELECT e.id, e.title, COUNT(t.id) as tickets_sold, SUM(sc.price) as total_sales
             FROM sp_events e
             JOIN sp_seats s ON s.event_id = e.id
             JOIN sp_tickets t ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             JOIN sp_orders o ON t.order_id = o.order_id
             JOIN sp_payments p ON o.order_id = p.order_id
             WHERE p.status = 'completed'
             GROUP BY e.id
             ORDER BY total_sales DESC"
        );
    }

    /**
     * Get recent orders
     * @param int $limit Number of orders to return
     * @return array Order objects
     */
    public function getRecentOrders($limit = 5)
    {
        $orders = $this->db->fetchAll(
            "SELECT o.*, 
                    u.name as user_name,
                    COUNT(t.id) as ticket_count, 
                    SUM(sc.price) as total_price,
                    (SELECT p.status FROM sp_payments p WHERE p.order_id = o.order_id ORDER BY p.paid_at DESC LIMIT 1) as payment_status
             FROM sp_orders o
             JOIN sp_users u ON o.user_id = u.id
             JOIN sp_tickets t ON o.order_id = t.order_id
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             GROUP BY o.order_id
             ORDER BY o.order_date DESC
             LIMIT ?",
            [$limit]
        );

        $orderObjects = [];
        foreach ($orders as $order) {
            $orderObjects[] = new Order($order);
        }

        return $orderObjects;
    }

    /**
     * Count orders by status
     * @param string $status Order status
     * @return int Number of orders with the given status
     */
    public function countOrdersByStatus($status)
    {
        if ($status === 'paid') {
            $result = $this->db->fetch(
                "SELECT COUNT(DISTINCT o.order_id) as count
                 FROM sp_orders o
                 JOIN sp_payments p ON o.order_id = p.order_id
                 WHERE p.status = 'completed'"
            );
        } else {
            $result = $this->db->fetch(
                "SELECT COUNT(DISTINCT o.order_id) as count
                 FROM sp_orders o
                 LEFT JOIN sp_payments p ON o.order_id = p.order_id
                 WHERE (p.status IS NULL OR p.status != 'completed')"
            );
        }

        return (int)$result['count'];
    }

    /**
     * Get monthly sales
     * @param int $months Number of months to look back
     * @return array Array of monthly sales data
     */
    public function getMonthlySales($months = 6)
    {
        return $this->db->fetchAll(
            "SELECT DATE_FORMAT(o.order_date, '%Y-%m') as month,
                    COUNT(DISTINCT o.order_id) as orders,
                    SUM(sc.price) as total_sales
             FROM sp_orders o
             JOIN sp_tickets t ON o.order_id = t.order_id
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             JOIN sp_payments p ON o.order_id = p.order_id
             WHERE p.status = 'completed'
             AND o.order_date >= DATE_SUB(NOW(), INTERVAL ? MONTH)
             GROUP BY month
             ORDER BY month DESC",
            [$months]
        );
    }

    /**
     * Get order statuses
     * @return array Array of order status data
     */
    public function getOrderStatuses()
    {
        return [
            'pending' => $this->countOrdersByStatus('pending'),
            'paid' => $this->countOrdersByStatus('paid'),
            'cancelled' => $this->countOrdersByStatus('cancelled')
        ];
    }

    /**
     * Get order items
     * @param int $orderId Order ID
     * @return array Array of order items
     */
    public function getOrderItems($orderId)
    {
        return $this->db->fetchAll(
            "SELECT t.id, e.title as event_title, e.start_datetime,
                    s.row_index, s.col_index, sc.name as category_name, sc.price
             FROM sp_tickets t
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_events e ON s.event_id = e.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             WHERE t.order_id = ?
             ORDER BY e.title, s.row_index, s.col_index",
            [$orderId]
        );
    }

    /**
     * Get order status history
     * @param int $orderId Order ID
     * @return array Array of status history entries
     */
    public function getOrderStatusHistory($orderId)
    {
        return $this->db->fetchAll(
            "SELECT status, created_at, 
                    (SELECT name FROM sp_users u WHERE u.id = h.created_by) as created_by_name
             FROM sp_order_status_history h
             WHERE order_id = ?
             ORDER BY created_at DESC",
            [$orderId]
        );
    }

    /**
     * Process refund
     * @param int $orderId Order ID
     * @param float $amount Refund amount
     * @param string $reason Refund reason
     * @return bool True if successful, false otherwise
     */
    public function processRefund($orderId, $amount, $reason)
    {
        try {
            $this->db->beginTransaction();

            // Get original payment
            $payment = $this->db->fetch(
                "SELECT * FROM sp_payments WHERE order_id = ? AND status = 'completed'",
                [$orderId]
            );

            if (!$payment) {
                $this->db->rollback();
                return false;
            }

            // Create refund record
            $this->db->query(
                "INSERT INTO sp_refunds (order_id, payment_id, amount, reason, status, created_at)
                 VALUES (?, ?, ?, ?, 'pending', NOW())",
                [$orderId, $payment['id'], $amount, $reason]
            );

            // Update payment status
            if ($amount >= $payment['amount']) {
                $this->db->query(
                    "UPDATE sp_payments SET status = 'refunded' WHERE id = ?",
                    [$payment['id']]
                );
            } else {
                $this->db->query(
                    "UPDATE sp_payments SET status = 'partially_refunded' WHERE id = ?",
                    [$payment['id']]
                );
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Get orders with filters
     * @param array $filters Filter criteria
     * @param int $offset Number of orders to skip
     * @param int $limit Maximum number of orders to return
     * @return array Array with orders and total count
     */
    public function getOrders($filters = [], $offset = 0, $limit = 20)
    {
        $where = [];
        $params = [];

        if (!empty($filters['user_id'])) {
            $where[] = "o.user_id = ?";
            $params[] = $filters['user_id'];
        }

        if (!empty($filters['status'])) {
            if ($filters['status'] === 'paid') {
                $where[] = "EXISTS (SELECT 1 FROM sp_payments p WHERE p.order_id = o.order_id AND p.status = 'completed')";
            } elseif ($filters['status'] === 'pending') {
                $where[] = "NOT EXISTS (SELECT 1 FROM sp_payments p WHERE p.order_id = o.order_id AND p.status = 'completed')";
            }
        }

        if (!empty($filters['date_from'])) {
            $where[] = "o.order_date >= ?";
            $params[] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $where[] = "o.order_date <= ?";
            $params[] = $filters['date_to'];
        }

        if (!empty($filters['event_id'])) {
            $where[] = "EXISTS (
                SELECT 1 FROM sp_tickets t 
                JOIN sp_seats s ON t.seat_id = s.id 
                WHERE t.order_id = o.order_id AND s.event_id = ?
            )";
            $params[] = $filters['event_id'];
        }

        $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";

        // Get total count
        $countSql = "SELECT COUNT(DISTINCT o.order_id) as total 
                     FROM sp_orders o 
                     $whereClause";
        $totalResult = $this->db->fetch($countSql, $params);
        $total = (int)$totalResult['total'];

        // Get orders
        $params = array_merge($params, [$limit, $offset]);
        $orders = $this->db->fetchAll(
            "SELECT o.*, 
                    COUNT(t.id) as ticket_count, 
                    SUM(sc.price) as total_price,
                    (SELECT p.status FROM sp_payments p WHERE p.order_id = o.order_id ORDER BY p.paid_at DESC LIMIT 1) as payment_status
             FROM sp_orders o
             JOIN sp_tickets t ON o.order_id = t.order_id
             JOIN sp_seats s ON t.seat_id = s.id
             JOIN sp_seat_categories sc ON s.seat_category_id = sc.id
             $whereClause
             GROUP BY o.order_id
             ORDER BY o.order_date DESC
             LIMIT ? OFFSET ?",
            $params
        );

        $orderObjects = [];
        foreach ($orders as $order) {
            $orderObjects[] = new Order($order);
        }

        return [
            'orders' => $orderObjects,
            'total' => $total
        ];
    }

    /**
     * Get detailed order information
     * @param int $orderId Order ID
     * @return array|false Order details or false if not found
     */
    public function getOrderDetail($orderId)
    {
        $order = $this->getOrderById($orderId);
        if (!$order) {
            return false;
        }

        $tickets = $this->getTicketsForOrder($orderId);
        $statusHistory = $this->getOrderStatusHistory($orderId);
        $payment = $this->db->fetch(
            "SELECT * FROM sp_payments WHERE order_id = ? ORDER BY created_at DESC LIMIT 1",
            [$orderId]
        );

        $refunds = $this->db->fetchAll(
            "SELECT * FROM sp_refunds WHERE order_id = ? ORDER BY created_at DESC",
            [$orderId]
        );

        return [
            'order' => $order,
            'tickets' => $tickets,
            'status_history' => $statusHistory,
            'payment' => $payment,
            'refunds' => $refunds
        ];
    }

    /**
     * Get order status name
     * @param int $statusId Status ID
     * @return string Status name
     */
    private function getOrderStatusName($statusId)
    {
        $statuses = [
            1 => 'pending',
            2 => 'paid',
            3 => 'cancelled',
            4 => 'refunded'
        ];

        return $statuses[$statusId] ?? 'unknown';
    }
}

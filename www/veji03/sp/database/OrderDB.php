<?php
require_once __DIR__ . '/Database.php';

class OrderDB {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    public function getOrdersByUser(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT o.id, o.created_at, o.street, o.city, o.zip, o.country, o.payment_method, o.note, o.status,
                   SUM(oi.quantity * oi.price) AS total
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            WHERE o.user_id = ?
            GROUP BY o.id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredOrders(int $limit, int $offset, ?string $statusFilter = null): array {
        $sql = "
            SELECT o.id, o.created_at, o.street, o.city, o.zip, o.country, o.payment_method, o.note, o.status,
                   u.first_name, u.last_name, u.email,
                   SUM(oi.quantity * oi.price) AS total
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN order_items oi ON oi.order_id = o.id
        ";

        $params = [];
        if ($statusFilter !== null && $statusFilter !== '') {
            $sql .= " WHERE o.status = :status ";
            $params[':status'] = $statusFilter;
        }

        $sql .= " GROUP BY o.id ORDER BY o.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        if (!empty($params[':status'])) {
            $stmt->bindValue(':status', $params[':status'], PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countOrders(?string $statusFilter = null): int {
        $sql = "SELECT COUNT(DISTINCT o.id) FROM orders o";
        $params = [];

        if ($statusFilter !== null && $statusFilter !== '') {
            $sql .= " WHERE o.status = :status";
            $params[':status'] = $statusFilter;
        }

        $stmt = $this->pdo->prepare($sql);
        if (!empty($params[':status'])) {
            $stmt->bindValue(':status', $params[':status'], PDO::PARAM_STR);
        }
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    public function getItemsByOrderId(int $orderId): array {
        $stmt = $this->pdo->prepare("
            SELECT p.name, oi.quantity, oi.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

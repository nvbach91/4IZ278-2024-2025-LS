<?php

/**
 * Orders page - displays user's orders
 */

// Initialize the application
require_once 'includes/init.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    setFlashMessage('error', 'You must be logged in to view your orders.');
    redirect(SITE_URL . '/login.php');
}

// Initialize models
$orderModel = new OrderDb();

// Get user orders
$orders = $orderModel->getOrdersForUser($_SESSION['user_id']);

// Process order cancelation
if (isset($_POST['cancel_order']) && isset($_POST['order_id'])) {
    // Verify CSRF token
    if (!checkCSRFToken()) {
        setFlashMessage('error', 'Invalid form submission.');
    } else {
        $orderId = (int)$_POST['order_id'];
        $order = $orderModel->getOrderById($orderId);

        if ($order && $orderModel->cancelOrder($order)) {
            setFlashMessage('success', 'Order canceled successfully.');
        } else {
            setFlashMessage('error', 'Failed to cancel order. Only pending orders can be canceled.');
        }
    }

    // Redirect to refresh the page
    redirect(SITE_URL . '/orders.php');
}

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <h1>My Orders</h1>

    <?php displayFlashMessages(); ?>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">
            You haven't placed any orders yet. <a href="<?php echo SITE_URL; ?>">Browse events</a> to get tickets.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($orders as $order): ?>
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Order #<?php echo $order->order_id; ?></h5>
                            <span class="badge <?php echo $order->payment_status === 'completed' ? 'badge-success' : ($order->payment_status === 'cancelled' ? 'badge-danger' : 'badge-warning'); ?>">
                                <?php echo $order->payment_status ? ucfirst($order->payment_status) : 'Pending'; ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Date:</strong> <?php echo formatDate($order->order_date); ?></p>
                                    <p><strong>Tickets:</strong> <?php echo $order->ticket_count; ?></p>
                                    <p><strong>Total:</strong> <?php echo $order->total_price; ?> CZK</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="order_detail.php?id=<?php echo $order->order_id; ?>" class="btn btn-primary">
                                        View Tickets
                                    </a>

                                    <?php if ($order->payment_status === 'pending'): ?>
                                        <form method="post" action="orders.php" class="d-inline-block ml-2">
                                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                            <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
                                            <button type="submit" name="cancel_order" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to cancel this order?');">
                                                Cancel Order
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mt-3">
                                <h6>Event Tickets</h6>
                                <?php
                                $tickets = $orderModel->getTicketsForOrder($order->order_id);
                                $groupedTickets = [];

                                // Group tickets by event
                                foreach ($tickets as $ticket) {
                                    if (!isset($groupedTickets[$ticket->event_title])) {
                                        $groupedTickets[$ticket->event_title] = [
                                            'event_title' => $ticket->event_title,
                                            'start_datetime' => $ticket->start_datetime,
                                            'location' => $ticket->location,
                                            'count' => 0
                                        ];
                                    }
                                    $groupedTickets[$ticket->event_title]['count']++;
                                }
                                ?>

                                <ul class="list-group">
                                    <?php foreach ($groupedTickets as $eventTitle => $eventData): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo escape($eventTitle); ?></strong><br>
                                                <small>
                                                    <?php echo formatDate($eventData['start_datetime']); ?> |
                                                    <?php echo escape($eventData['location']); ?>
                                                </small>
                                            </div>
                                            <span class="badge badge-primary badge-pill">
                                                <?php echo $eventData['count']; ?> ticket<?php echo $eventData['count'] > 1 ? 's' : ''; ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
// Include the footer
include 'views/footer.php';
?>
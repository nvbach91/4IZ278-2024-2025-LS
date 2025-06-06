<?php

/**
 * Order detail page - displays order details and tickets
 */

// Initialize the application
require_once 'includes/init.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    setFlashMessage('error', 'You must be logged in to view order details.');
    redirect(SITE_URL . 'login.php');
}

// Get order ID from URL
$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize models
$orderModel = new OrderDb();

// Get order details
$order = $orderModel->getOrderById($orderId);

// Verify that the order exists and belongs to the current user
if (!$order || $order->user_id != $_SESSION['user_id']) {
    setFlashMessage('error', 'Order not found or access denied.');
    redirect(SITE_URL . 'orders.php');
}

// Get tickets for the order
$tickets = $orderModel->getTicketsForOrder($orderId);

// Calculate total price
$totalPrice = 0;
foreach ($tickets as $ticket) {
    $totalPrice += $ticket->price;
}

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order Details</h1>
        <a href="<?php echo SITE_URL; ?>orders.php" class="btn btn-secondary">
            Back to Orders
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Order #<?php echo $order->order_id; ?></h3>
            <span class="badge <?php echo $order->payment_status === 'completed' ? 'badge-success' : ($order->payment_status === 'cancelled' ? 'badge-danger' : 'badge-warning'); ?>">
                <?php echo ucfirst($order->payment_status ?? 'pending'); ?>
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Order Date:</strong> <?php echo formatDate($order->order_date); ?></p>
                    <p><strong>Number of Tickets:</strong> <?php echo count($tickets); ?></p>
                    <p><strong>Total Price:</strong> <?php echo $totalPrice; ?> CZK</p>
                </div>

                <?php if ($order->payment_status === 'pending'): ?>
                    <div class="col-md-6 text-right">
                        <form method="post" action="orders.php">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                            <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
                            <button type="submit" name="cancel_order" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to cancel this order?');">
                                Cancel Order
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <h2>Your Tickets</h2>

    <?php if (empty($tickets)): ?>
        <div class="alert alert-info">
            No tickets found for this order.
        </div>
    <?php else: ?>
        <?php
        // Group tickets by event
        $ticketsByEvent = [];
        foreach ($tickets as $ticket) {
            if (!isset($ticketsByEvent[$ticket->event_title])) {
                $ticketsByEvent[$ticket->event_title] = [
                    'event_title' => $ticket->event_title,
                    'start_datetime' => $ticket->start_datetime,
                    'location' => $ticket->location,
                    'tickets' => []
                ];
            }
            $ticketsByEvent[$ticket->event_title]['tickets'][] = $ticket;
        }
        ?>

        <?php foreach ($ticketsByEvent as $eventTitle => $eventData): ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><?php echo escape($eventTitle); ?></h4>
                </div>
                <div class="card-body">
                    <p>
                        <strong>Date:</strong> <?php echo formatDate($eventData['start_datetime']); ?><br>
                        <strong>Location:</strong> <?php echo escape($eventData['location']); ?>
                    </p>

                    <h5>Tickets</h5>
                    <div class="row">
                        <?php foreach ($eventData['tickets'] as $ticket): ?>
                            <div class="col-md-6 mb-3">
                                <div class="ticket">
                                    <div class="ticket-header">
                                        <div class="ticket-event"><?php echo escape($eventTitle); ?></div>
                                        <div class="text-muted"><?php echo formatDate($eventData['start_datetime']); ?></div>
                                    </div>
                                    <div class="ticket-info">
                                        <div>
                                            <strong>Row:</strong> <?php echo $ticket->row_index; ?><br>
                                            <strong>Seat:</strong> <?php echo $ticket->col_index; ?><br>
                                            <strong>Category:</strong> <?php echo escape($ticket->category_name); ?>
                                        </div>
                                        <div class="text-right">
                                            <strong>Price:</strong><br>
                                            <?php echo $ticket->price; ?> CZK<br>
                                            <?php if ($order->payment_status === 'completed'): ?>
                                                <span class="badge badge-success">completed</span>
                                            <?php else: ?>
                                                <span class="badge badge-warning">PENDING</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if ($order->payment_status === 'completed'): ?>
                                        <div class="mt-3 text-center">
                                            <a href="ticket.php?id=<?php echo $ticket->id; ?>" class="btn btn-sm btn-primary">
                                                View E-Ticket
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
// Include the footer
include 'views/footer.php';
?>
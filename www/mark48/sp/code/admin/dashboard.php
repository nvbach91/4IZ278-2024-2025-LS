<?php

/**
 * Admin Dashboard
 */

// Initialize the application
require_once '../includes/init.php';

// Redirect if not logged in as admin
if (!isLoggedIn() || !isAdmin()) {
    setFlashMessage('error', 'Access denied. Admin privileges required.');
    redirect(SITE_URL);
}

// Initialize models
$eventModel = new EventDb();
$seatModel = new SeatDb();
$userModel = new UserDb();
$orderModel = new OrderDb();

// Get recent orders (last 5)
$recentOrders = $orderModel->getRecentOrders(5);

// Get upcoming events
$upcomingEvents = $eventModel->getUpcomingEvents(5);

// Get sales by event
$salesByEvent = $orderModel->getSalesByEvent();

// Include the header
include '../views/admin_header.php';
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Dashboard</h1>
                <div>
                    <a href="<?php echo SITE_URL; ?>admin/events.php?action=create" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Create Event
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Sales by Event Table -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Sales by Event</h4>
                        </div>
                        <div class="card-body">
                            <?php if (empty($salesByEvent)): ?>
                                <div class="alert alert-info">
                                    No sales data available yet.
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Event</th>
                                                <th>Tickets Sold</th>
                                                <th class="text-right">Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($salesByEvent as $event): ?>
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo SITE_URL; ?>admin/events.php?action=edit&id=<?php echo $event['id']; ?>">
                                                            <?php echo htmlspecialchars($event['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $event['tickets_sold']; ?></td>
                                                    <td class="text-right"><?php echo number_format($event['total_sales'], 0); ?> CZK</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (count($salesByEvent) > 5): ?>
                                    <div class="mt-2 text-right">
                                        <a href="<?php echo SITE_URL; ?>admin/reports.php" class="btn btn-sm btn-outline-primary">View Full Report</a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Recent Orders</h4>
                        </div>
                        <div class="card-body">
                            <?php if (empty($recentOrders)): ?>
                                <div class="alert alert-info">
                                    No recent orders.
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer</th>
                                                <th>Tickets</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentOrders as $order): ?>
                                                <?php
                                                $statusClass = 'secondary';
                                                $statusName = 'Unknown';

                                                switch ($order->payment_status) {
                                                    case 'pending':
                                                        $statusClass = 'warning';
                                                        $statusName = 'Pending';
                                                        break;
                                                    case 'completed':
                                                        $statusClass = 'success';
                                                        $statusName = 'Completed';
                                                        break;
                                                    case 'failed':
                                                        $statusClass = 'danger';
                                                        $statusName = 'Failed';
                                                        break;
                                                    case 'refunded':
                                                        $statusClass = 'info';
                                                        $statusName = 'Refunded';
                                                        break;
                                                    case 'partially_refunded':
                                                        $statusClass = 'warning';
                                                        $statusName = 'Partially Refunded';
                                                        break;
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        #<?php echo $order->order_id; ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($order->user_name ?? 'Unknown', ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo $order->ticket_count; ?></td>
                                                    <td><?php echo number_format($order->total_price ?? 0, 0); ?> CZK</td>
                                                    <td><?php echo formatDate($order->order_date); ?></td>
                                                    <td><span class="badge badge-<?php echo $statusClass; ?>"><?php echo htmlspecialchars($statusName, ENT_QUOTES, 'UTF-8'); ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Upcoming Events</h4>
                        </div>
                        <div class="card-body">
                            <?php if (empty($upcomingEvents)): ?>
                                <div class="alert alert-info">
                                    No upcoming events.
                                </div>
                            <?php else: ?>
                                <ul class="list-group">
                                    <?php foreach ($upcomingEvents as $event): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo htmlspecialchars($event->title ?? '', ENT_QUOTES, 'UTF-8'); ?></strong><br>
                                                <small><?php echo formatDate($event->start_datetime); ?></small>
                                            </div>
                                            <div>
                                                <a href="<?php echo SITE_URL; ?>admin/events.php?action=edit&id=<?php echo $event->id; ?>" class="btn btn-sm btn-primary mr-1">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="<?php echo SITE_URL; ?>event.php?id=<?php echo $event->id; ?>" class="btn btn-sm btn-secondary" target="_blank">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <div class="mt-3">
                                    <a href="<?php echo SITE_URL; ?>admin/events.php" class="btn btn-outline-primary btn-sm">View All Events</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include the footer
include '../views/footer.php';
?>
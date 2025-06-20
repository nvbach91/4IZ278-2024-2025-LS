<?php include __DIR__ . '/prefix.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__ .'/vendor/autoload.php'; ?>
<?php require_once __DIR__.'/database/OrdersDB.php';?>
<?php require_once __DIR__.'/database/OrderItemsDB.php';?>
<?php require_once __DIR__.'/database/ProductsDB.php';?>
<?php
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$ordersDB = new OrdersDB();
$orderItemsDB = new OrderItemsDB();
$productsDB = new ProductsDB();
$userId = $_SESSION['user']['id'];

$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

if ($statusFilter === 'completed') {
    $orders = $ordersDB->getOrdersByUserIdAndStatus($userId, 1);
} elseif ($statusFilter === 'pending') {
    $orders = $ordersDB->getOrdersByUserIdAndStatus($userId, 0);
} else {
    $orders = $ordersDB->getOrdersByUserId($userId);
}

if (!$orders) {
    $orders = [];
}

ob_start();
$csrf->insertToken();
$csrf_token_input = ob_get_clean();

?>

<?php include __DIR__.'/includes/head.php';?>
<div class="container">
    <form method="get" class="my-3">
        <label for="status" class="form-label">Filter by status:</label>
        <select name="status" id="status" class="form-select" onchange="this.form.submit()">
            <option value="all" <?php if ($statusFilter === 'all') echo 'selected'; ?>>All</option>
            <option value="completed" <?php if ($statusFilter === 'completed') echo 'selected'; ?>>Completed</option>
            <option value="pending" <?php if ($statusFilter === 'pending') echo 'selected'; ?>>Pending</option>
        </select>
    </form>

    <?php if (empty($orders)): ?>
        <h1 class='my-4'>No orders found</h1>
    <?php else: ?>
        <h1 class='my-4'>Order History</h1>
        <div class="row">  
            <?php include __DIR__.'/orders.php'; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__.'/includes/foot.php';?>
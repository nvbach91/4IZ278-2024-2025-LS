<?php include __DIR__ . '/prefix.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__.'/database/OrdersDB.php';?>
<?php require_once __DIR__.'/database/OrderItemsDB.php';?>
<?php require_once __DIR__.'/database/ProductsDB.php';?>
<?php
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
        <h1 class='my-4'>You don't have any orders.</h1>
    <?php else: ?>
        <h1 class='my-4'>Order History</h1>
        <div class="row">  
        <?php foreach ($orders as $order) {
            $items = $orderItemsDB->getItemsByOrderId($order['order_id']);
            if ($items) {
                $total = 0;
                foreach ($items as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
                ?>
                <div class="col-12 mb-3">
                    <details>
                        <summary>
                            <div class="d-inline-flex align-items-center flex-wrap gap-2 justify-content-start">
                                <table class="w-100" style="table-layout: fixed; max-width: 500px;">
                                    <tr>
                                        <td style="width: 15%; text-align: left;">
                                            Order #<?php echo(htmlspecialchars($order['order_id'])) ?>
                                        </td>
                                        <td style="width: 32%; text-align: left;">
                                            from <?php echo(htmlspecialchars(date('d.m.Y H:i', strtotime($order['date'])))) ?>
                                        </td>
                                        <td style="width: 26%; text-align: left;">
                                            Total: <?php echo($total) ?> Kč
                                        </td>
                                        <td style="width: 27%; text-align: left;">
                                            Status:
                                            <?php if ($order['completed']==1): ?>
                                                <span class="badge bg-success">Completed</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                                <a href="<?php echo $urlPrefix ?>/download_invoice.php?order_id=<?php echo urlencode($order['order_id']); ?>" class="btn btn-primary btn-sm d-flex align-items-center">
                                    <span class="material-symbols-outlined">download</span>
                                    Invoice
                                </a>
                            </div>
                        </summary>
                        <table class="table table-hover table-striped table-sm mt-2">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): 
                                    $itemDB=$productsDB->fetchProductByID($item['product_id'])?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo $urlPrefix ?>/product.php?id=<?php echo urlencode($itemDB['product_id']); ?>">
                                                <?php echo htmlspecialchars($itemDB['name']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo(htmlspecialchars($item['quantity'])) ?></td>
                                        <td><?php echo($item['price'] * $item['quantity']) ?> Kč</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total: <?php echo($total) ?> Kč</th>
                                </tr>
                            </tfoot>
                        </table>
                    </details>
                </div>
                <?php
            }
        }
        ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__.'/includes/foot.php';?>
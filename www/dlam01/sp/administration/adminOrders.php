<?php
require_once __DIR__ . '/../database/OrdersDB.php';
session_start();
unset($_SESSION['errors']);
if (!isset($_SESSION['privilege']) || $_SESSION['privilege'] < 2) {
    header("Location: index.php");
    exit;
}
$ordersDB = new OrdersDB();
$orders = $ordersDB->fetch(null);

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchQuery !== '') {
    $orders = array_filter($orders, function ($order) use ($searchQuery) {
        return (
            (isset($order['id']) && stripos((string)$order['id'], $searchQuery) !== false)
        );
    });
}
?>
<?php include __DIR__ . "/../includes/header.php"; ?>
<?php if (isset($_SESSION["success"])): ?>
    <div class='alert alert-success' role='alert'>
        <?php echo $_SESSION["success"]; ?>
    </div>
<?php endif; ?>
<div class="container">
    <div class="text-start my-4">
        <a href="adminProducts.php" class="btn btn-primary btn-lg mx-2">Manage Products</a>
        <a href="adminOrders.php" class="btn btn-primary btn-lg mx-2">Manage Orders</a>
        <?php if ($_SESSION['privilege'] == 3): ?>
            <a href="adminUsers.php" class="btn btn-primary btn-lg mx-2">Manage Users</a>
        <?php endif; ?>
    </div>
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by order ID" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <?php
    $itemsPerPage = 20;
    $totalItems = count($orders);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;
    $paginatedOrders = array_slice($orders, $offset, $itemsPerPage);
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>user_id</th>
                <th>Status</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paginatedOrders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td><?php echo htmlspecialchars($order['total_price']); ?></td>
                    <td>
                         <?php if ($order['status'] != 3): ?>
                        <a href="adminCancelOrder.php?id=<?php echo urlencode($order['id']); ?>" class="btn btn-warning btn-sm">Cancel</a>
                        <?php endif; ?>
                        <?php if ($order['status'] == 1): ?>
                        <a href="adminConfirmOrder.php?id=<?php echo urlencode($order['id']); ?>" class="btn btn-success btn-sm">Confirm</a>
                        <?php endif; ?>
                        <a href="../orderDetail.php?id=<?php echo urlencode($order['id']); ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                <li class="page-item <?php echo $page == $currentPage ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page; ?>&search=<?php echo urlencode($searchQuery); ?>"><?php echo $page; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<div style="margin-bottom: 30px"></div>
<?php include __DIR__ . "/../includes/footer.php"; ?>
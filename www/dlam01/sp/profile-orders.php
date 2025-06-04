<?php include_once __DIR__ . '/includes/header.php'; ?>
<main class="container">
    <div class="text-start my-4">
        <a href="profile-information.php" class="btn btn-primary btn-lg mx-2">My profile</a>
        <a href="profile-orders.php" class="btn btn-primary btn-lg mx-2">My orders</a>
    </div>
    <h1>My Orders</h1>
    <?php
    require_once __DIR__ . '/database/OrdersDB.php';
    $ordersDB = new OrdersDB();

    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }

    $userId = $_SESSION['user_id'];
    $orders = $ordersDB->fetchByUserId($userId);

    if (empty($orders)) {
        ?>
        <p>No orders found.</p>
        <?php
    } else {
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Address</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['date']) ?></td>
                        <td><?= htmlspecialchars($order['city']) . ', ' . htmlspecialchars($order['street']) . ', ' . htmlspecialchars($order['zip_code']) ?></td>
                        <td><?= htmlspecialchars($order['total_price']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }
    ?>
</main>
<?php include_once __DIR__ . '/includes/footer.php'; ?>
<?php include __DIR__.'/prefix.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__ .'/vendor/autoload.php'; ?>
<?php require_once __DIR__.'/database/OrdersDB.php'; ?>
<?php require_once __DIR__.'/database/OrderItemsDB.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php require_once __DIR__.'/database/UsersDB.php'; ?>
<?php require_once __DIR__.'/utils/Email.php'; ?>
<?php
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$ordersDB = new OrdersDB();
$orderItemsDB = new OrderItemsDB();
$productsDB = new ProductsDB();
$UsersDB = new UsersDB();
$emailClient = new Email();

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $order = $ordersDB->getOrderByOrderId($orderId);
    if (!$order) {
        header('Location:'.$urlPrefix.'/index.php');
        exit;
    }
    $user = $UsersDB->fetchUserById($order['user_id']);
    $isAdmin = isset($_SESSION['user']['privilege']) && ($_SESSION['user']['privilege'] >= 2);
    
    if (!$isAdmin && $order['user_id'] != $_SESSION['user']['id']) {
        header('Location:'.$urlPrefix.'/index.php');
        exit;
    }
    
    $items = $orderItemsDB->getItemsByOrderId($orderId);

    $total = 0;
    foreach ($items as $item) {
        $product = $productsDB->fetchProductByID($item['product_id']);
        if ($product) {
            $total += $item['price'] * $item['quantity'];
        }
    }
}

if (isset($_POST['change_status']) && isset($_POST['order_id'])) {
    if (!$csrf->validateRequest()) {
        echo 'Invalid CSRF token';
        http_response_code(403);
        $log->error('Invalid CSRF token on order-item.php', [
            'orderId' => $_POST['order_id'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
        exit();
    }
    $orderId = (int)($_POST['order_id']);
    $status = (int)($_POST['completed']);
    $ordersDB->updateOrderStatus($orderId, $status);
    $user = $ordersDB->getUserByOrderId($orderId);
    $email = $user['email'];
    $emailClient->sendOrderStatusChange($orderId, $status, $email);
    header('Location: '.$urlPrefix.'/orders-item.php?id='.$orderId);
    exit();
}

?>

<?php include __DIR__.'/includes/head.php';?>
<div class="container">
    <h1 class='my-4'>Order #<?php echo($order['order_id'])?></h1>
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

        <a href="<?php echo $urlPrefix ?>/download_invoice.php?order_id=<?php echo urlencode($order['order_id']); ?>" target="_blank" class="btn btn-primary btn-sm d-flex align-items-center">
            <span class="material-symbols-outlined">download</span>
            Invoice
        </a>
        <?php if($isAdmin): ?>
            <div class="d-inline-flex align-items-center flex-wrap gap-2" style="vertical-align: middle;">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?id=<?php echo($order['order_id'])?>" class="d-flex align-items-center gap-2 mb-0 flex-wrap" style="vertical-align: middle;">
                    <?php $csrf->insertToken();?>
                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                    <select name="completed" class="form-select w-auto" style="min-width: 120px;">
                        <option value="1" <?php if ($order['completed']==1) echo 'selected'; ?>>Completed</option>
                        <option value="0" <?php if ($order['completed']==0) echo 'selected'; ?>>Pending</option>
                    </select>
                    <button type="submit" name="change_status" class="btn btn-sm btn-primary">
                        <span class="material-symbols-outlined align-middle">save</span>
                        Change
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <?php if($isAdmin): ?>
        <p>
            Name: <?php echo isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?><br>
            Email: <?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?><br>
            Phone: <?php echo isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?><br>
            Address: <?php echo isset($user['address']) ? htmlspecialchars($user['address']) : ''; ?>
        </p>
    <?php endif; ?>

    <table class="table table-hover table-striped table-sm mt-2" id="order-<?php echo htmlspecialchars($order['order_id']); ?>">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit price</th>
                <th>Total price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <?php $itemDB = $productsDB->fetchProductByID($item['product_id']); ?>
                <?php if (!$itemDB) continue; // Skip if product not found ?>
                <tr>
                    <td>
                        <a href="<?php echo $urlPrefix ?>/product.php?id=<?php echo urlencode($itemDB['product_id']); ?>">
                            <?php echo htmlspecialchars($itemDB['name']); ?>
                        </a>
                    </td>
                    <td><?php echo(htmlspecialchars($item['quantity'])) ?></td>
                    <td><?php echo(htmlspecialchars($item['price'])) ?> Kč</td>
                    <td><?php echo($item['price'] * $item['quantity']) ?> Kč</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3"></th>
                <th>Total: <?php echo($total) ?> Kč</th>
            </tr>
        </tfoot>
    </table>
</div>

<?php include __DIR__.'/includes/foot.php';?>
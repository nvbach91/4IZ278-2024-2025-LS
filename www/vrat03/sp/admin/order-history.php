<?php include __DIR__ . '/../prefix.php'; ?>
<?php include __DIR__.'/../privileges.php'; ?>
<?php require_once __DIR__ .'/../vendor/autoload.php'; ?>
<?php require_once __DIR__.'/../database/OrdersDB.php';?>
<?php require_once __DIR__.'/../database/OrderItemsDB.php';?>
<?php require_once __DIR__.'/../database/ProductsDB.php';?>
<?php require_once __DIR__.'/../database/UsersDB.php';?>
<?php include_once __DIR__.'/../utils/Email.php'; ?>
<?php
hasPrivilege(2);
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$ordersDB = new OrdersDB();
$orderItemsDB = new OrderItemsDB();
$productsDB = new ProductsDB();
$UsersDB = new UsersDB();
$emailClient = new Email();
$userId = $_SESSION['user']['id'];
$errors = [];

$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

//pagination
$isSelectedPage = !empty($_GET['page']);
$numberOfItemsPerPage=25;
if ($statusFilter === 'completed') {
    $numberOfRecords = $ordersDB->countOrdersWithStatus(1);
} elseif ($statusFilter === 'pending') {
    $numberOfRecords = $ordersDB->countOrdersWithStatus(0);
} else {
    $numberOfRecords = $ordersDB->countRecords([]);
}
$numberOfPages=ceil($numberOfRecords/$numberOfItemsPerPage);
$remainingOnTheLastPage=$numberOfRecords%$numberOfItemsPerPage;
$webPageNumber=$isSelectedPage ? $_GET['page'] : 1;
$pageNumber = $webPageNumber > $numberOfPages ? 1 : $webPageNumber;
$offset=($pageNumber-1)*$numberOfItemsPerPage;
if ($statusFilter === 'completed') {
    $ordersWithPageOffset = $ordersDB->fetchPaginationWithStatus($offset, $numberOfItemsPerPage, 1);
} elseif ($statusFilter === 'pending') {
    $ordersWithPageOffset = $ordersDB->fetchPaginationWithStatus($offset, $numberOfItemsPerPage, 0);
} else {
    $ordersWithPageOffset = $ordersDB->fetchPagination($offset, $numberOfItemsPerPage);
}
$productsWithPageOffset = $ordersDB->fetchPagination($offset, $numberOfItemsPerPage);
$orders = $ordersWithPageOffset;

if (!$orders) {
    $orders = [];
}

if (isset($_POST['change_status']) && isset($_POST['order_id'])) {
    if (!$csrf->validateRequest()) {
        echo 'Invalid CSRF token';
        http_response_code(403);
        $log->error('Invalid CSRF token on order-history.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
        exit();
    }
    $orderId = (int)($_POST['order_id']);
    $status = (int)($_POST['completed']);
    $user = $ordersDB->getUserByOrderId($orderId);
    $email = $user['email'];
    //$emailClient->sendOrderStatusChange($orderId, $status, $email);
    if ($status === 1) {
        if($ordersDB->decreaseProductQuantitiesByOrderId($orderId) === false) {
            $errors['alert'] = 'Error decreasing product quantities for order ID: '.$orderId.' Insufficient stock.';
        } else {
            $ordersDB->updateOrderStatus($orderId, $status);
            $errors['success'] = 'Order status changed successfully.';
            $emailClient->sendOrderStatusChange($orderId, $status, $email);
        }
    }
    if (!isset($errors['alert']) && !isset($errors['success'])) {
        header('Location: '.$urlPrefix.'/admin/order-history.php');
        exit();
    }
}

//preparation of URL parameters for pagination
if (!$_GET) {
        $parameters='?page=';
} elseif(isset($_GET['page'])) {
    $parametersWithoutPage=$_GET;
    unset($parametersWithoutPage['page']);
    $parameters='?'.http_build_query($parametersWithoutPage).'&page=';
} else {
    $parameters='?'.http_build_query($_GET).'&page=';
}
?>

<?php include __DIR__.'/../includes/head.php';?>
<div class="container">
    <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['alert']; ?>
    </div>
    <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['success']; ?>
    </div>
    <?php include __DIR__.'/order-history-items.php'; ?>
</div>

<?php include __DIR__.'/../includes/foot.php';?>
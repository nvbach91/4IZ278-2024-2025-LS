<?php require_once __DIR__ . '/vendor/autoload.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__.'/database/OrdersDB.php'; ?>
<?php require_once __DIR__.'/database/UsersDB.php'; ?>
<?php require_once __DIR__ . '/utils/PDF.php'; ?>
<?php
$ordersDB = new OrdersDB();
$usersDB = new UsersDB();
$pdf = new PDF();
$errors=[];
$loggedUserId = $_SESSION['user']['id'];
$privilege = $_SESSION['user']['privilege'];
$orderId = intval($_GET['order_id'] ?? 0);
$order = $ordersDB->getOrderByOrderId($orderId);
$user = $usersDB->fetchUserById($order['user_id']);

if ($orderId <= 0) {
    $errors['alert']="Invalid order ID.";

} else if (!$order) {
    $errors['alert']="Order not found.";

} else if ($order['user_id'] !== $loggedUserId && $privilege == '1') {
    $errors['alert']="You do not have permission to access this order.";

} else {
    $invoiceDir = __DIR__ . '/invoices';
    $invoicePath = "$invoiceDir/order_$orderId.pdf";


    if (!file_exists($invoicePath)) {
        $pdf->generateInvoice(htmlspecialchars($user['name']), htmlspecialchars($order['address']),
            htmlspecialchars($user['phone']), htmlspecialchars($user['email']),
            $orderId, 'A4', 'portrait', $invoiceDir
        );
    }

    header('Content-Type: application/pdf');
    header("Content-Disposition: inline; filename=\"order_$orderId.pdf\"");
    readfile($invoicePath);
    exit;
}
?>

<?php require __DIR__.'/includes/head.php';?>

<div class="container">
    <h1 class='my-4'>Download invoice</h1>
    <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['alert']; ?>
    </div>
</div>

<?php require __DIR__.'/includes/foot.php';?>
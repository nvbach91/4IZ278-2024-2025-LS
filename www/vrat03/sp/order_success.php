<?php include __DIR__.'/prefix.php'; ?>
<?php require __DIR__.'/includes/head.php';?>
<?php if(!isset($_GET['id'])) {
    header('Location: '.$urlPrefix.'/index.php');
    exit;
}
$id = htmlspecialchars($_GET['id']);
?>

<div class="container">
    <h1 class="my-4">Order no. <?php echo $id ?> was succesfull!</h1>
    <p>You can view your order details and download invoice in <a href='<?php echo $urlPrefix?>/account-history.php'>your account.</a></p>
</div>

<?php require __DIR__.'/includes/foot.php';?>
<?php include __DIR__ . '/includes/header.php';
if (!isset($_COOKIE['name'])) {
    header('Location: /4IZ278/DU/du06/includes/login.php');
}
?>
<!-- Page Content-->
<div class="container">
    <?php if ($_SESSION['privilege'] > 1) : ?>
        <a href="/4IZ278/DU/du06//includes/create-item.php" class="btn btn-primary">Add new item</a>
    <?php endif; ?>
    <div class="row">
        <?php include __DIR__ . '/includes/categoryDisplay.php'; ?>
        <div class="col-lg-9">
            <?php include __DIR__ . '/includes/slideDisplay.php'; ?>
            <?php include __DIR__ . '/includes/productDisplay.php'; ?>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
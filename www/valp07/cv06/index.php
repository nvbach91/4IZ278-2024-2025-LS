<?php require __DIR__ . '/includes/header.php'; ?>
<!-- Page Content-->
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <h1 class="my-4">Shop Name</h1>
            <?php require __DIR__ . '/components/CategoryDisplay.php'; ?>
        </div>
        <div class="col-lg-9">
            <?php require __DIR__ . '/components/SlideDisplay.php'; ?>
            <?php require __DIR__ . '/components/ProductDisplay.php'; ?>

        </div>
    </div>
</div>
<!-- Footer-->
<?php require __DIR__ . '/includes/footer.php'; ?>
<?php include __DIR__.'/../privileges.php'; ?>
<?php
hasPrivilege(2);
?>

<?php require __DIR__.'/../includes/head.php';?>

<div class="container">
    <h1 class="my-4">Admin Links</h1>
    <div class="col-3 list-group">
        <a href="<?php echo $urlPrefix ?>/admin/edit-items.php" class="list-group-item d-flex align-items-center">
            <span class="material-symbols-outlined">edit</span>
            Edit Items
        </a>
        <a href="<?php echo $urlPrefix ?>/admin/categories.php" class="list-group-item d-flex align-items-center">
            <span class="material-symbols-outlined">edit</span>
            Edit Categories
        </a>
        <a href="<?php echo $urlPrefix ?>/admin/order-history.php" class="list-group-item d-flex align-items-center">
            <span class="material-symbols-outlined">overview</span>    
            Order History
        </a>
        <a href="<?php echo $urlPrefix ?>/admin/users.php" class="list-group-item d-flex align-items-center">
            <span class="material-symbols-outlined">manage_accounts</span>
            Users
        </a>
    </div>
</div>

<?php require __DIR__.'/../includes/foot.php';?>
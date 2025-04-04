<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php

hasPrivilege(2);
$productsDB = new ProductsDB();
$isSetID = !empty($_GET['id']);

if ($isSetID) {
    $product = $productsDB->fetchProductByID($_GET['id']);
    if ($product) {
        $productsDB->deleteProduct($_GET['id']);
        header('Location: edit-items.php');
        exit;
    }
}
header("Location: edit-items.php");
exit;

?>
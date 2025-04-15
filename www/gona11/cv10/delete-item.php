<?php require_once __DIR__ . '/database/ProductsDB.php'?>
<?php 

    session_start();
    if (!isset($_GET['good_id']) || !is_numeric($_GET['good_id'])) {
        die('Such item does not exist.');
    }
    $productsDB = new ProductsDB();
    $goodId = (int) $_GET['good_id'];
    $productsDB->deleteItem($goodId);
    $_SESSION["deleteItemSuccess"] = "Item was succesfully deleted!";
    header('Location: ./index.php');
    exit();
?>
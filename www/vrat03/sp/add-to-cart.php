<?php require_once __DIR__ . '/prefix.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>
<?php require_once __DIR__.'/database/ProductsDB.php'; ?>
<?php
$productsDB = new ProductsDB();
$isSetID = !empty($_POST['id']);

if($isSetID) {
    $product = $productsDB->fetchProductByID($_POST['id']);
    if ($product) { // && $product['quantity'] > 0) {
        $found = false;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }else{
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $product['product_id']) {
                    $item['quantity'] += 1;
                    $found = true;
                    break;
                }
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
            'id' => $product['product_id'],
            'price' => $product['price'],
            'quantity' => 1,
            ];
        }

        //$productsDB->updateProductQuantity($product['product_id'], $product['quantity'] - 1);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json');
            echo json_encode(true);
            exit;
        }
        header('Location: '.$urlPrefix.'/cart.php');
        exit;
    } else {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json');
            echo json_encode(false);
            exit;
        }
        header('Location: '.$urlPrefix.'/index.php');
        exit;
    }
} else {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        header('Content-Type: application/json');
        echo json_encode(false);
        exit;
    }
    header('Location: '.$urlPrefix.'/index.php');
    exit;
}

?>
<?php
require_once __DIR__ . '/../../database-config/ProductsDB.php';

function getCartData()
{
    $cart = $_SESSION['cart'] ?? [];
    $items = [];
    $total = 0.0;

    if (!empty($cart)) {
        $productsDB = new ProductsDB();
        $ids = array_keys($cart);
        $products = $productsDB->getByIds($ids);

        $productMap = [];
        foreach ($products as $product) {
            $productMap[$product['id']] = $product;
        }

        foreach ($cart as $id => $qty) {
            if (!isset($productMap[$id])) continue;

            $product = $productMap[$id];
            $subtotal = $product['price'] * $qty;
            $items[] = [
                'id' => $id,
                'name' => $product['name'],
                'description' => $product['description'],
                'qty' => $qty,
                'price' => $product['price'],
                'subtotal' => $subtotal,
            ];
            $total += $subtotal;
        }
    }
    return [$items, $total];
}

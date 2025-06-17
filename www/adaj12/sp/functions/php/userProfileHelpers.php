<?php
// Funkce pro zjištění, zda je uživatel přihlášen
function isUserLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

// Funkce pro získání ID přihlášeného uživatele
function getLoggedInUserId(): ?int {
    return $_SESSION['user_id'] ?? null;
}

// Funkce pro načtení aktuálních údajů uživatele
function getCurrentUserData($userId): array {
    require_once __DIR__ . '/../../database-config/UsersDB.php';
    $usersDB = new UsersDB();
    return $usersDB->findById($userId) ?? [];
}

// Funkce pro získání všech objednávek uživatele i s položkami a produkty
function getUserOrdersWithItems($userId): array {
    require_once __DIR__ . '/../../database-config/OrdersDB.php';
    require_once __DIR__ . '/../../database-config/ProductsDB.php';

    $ordersDB = new OrdersDB();
    $productsDB = new ProductsDB();
    $orders = $ordersDB->getOrdersByUserId($userId);
    foreach ($orders as &$order) {
        $order['items'] = $ordersDB->getOrderItems($order['id']);
        $order['address'] = json_decode($order['shipping_address'], true);
        foreach ($order['items'] as &$item) {
            $item['product'] = $productsDB->findById($item['game_id']);
        }
    }
    return $orders;
}

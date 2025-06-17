<?php
session_start();
require_once __DIR__ . '/../../database-config/UsersDB.php';

// Ověření přihlášení
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../pages/login.php?error=Pro pokračování je nutné se přihlásit.');
    exit;
}

$userId = $_SESSION['user_id'];
$usersDB = new UsersDB();
$user = $usersDB->findById($userId);

// Získání údajů z POST
$shipping_name = trim($_POST['shipping_name'] ?? '');
$shipping_street = trim($_POST['shipping_street'] ?? '');
$shipping_postal_code = trim($_POST['shipping_postal_code'] ?? '');
$shipping_city = trim($_POST['shipping_city'] ?? '');
$shipping_phone = trim($_POST['shipping_phone'] ?? '');
$user_email = trim($_POST['user_email'] ?? '');

$shipping_method = $_POST['shipping_method'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$agreement = $_POST['agreement'] ?? null;

$error = '';
if (!$shipping_name || !$shipping_street || !$shipping_postal_code || !$shipping_city || !$shipping_phone || !$user_email || !$shipping_method || !$payment_method || !$agreement) {
    $error = 'Vyplňte všechna povinná pole.';
}
// VALIDACE
if (!$error && strlen($shipping_name) < 3) $error = 'Zadejte jméno a příjmení (alespoň 3 znaky).';
if (!$error && strlen($shipping_street) < 3) $error = 'Zadejte ulici a číslo popisné (alespoň 3 znaky).';
if (!$error && !preg_match('/^\d{3}\s?\d{2}$/', $shipping_postal_code)) $error = 'Zadejte platné PSČ (např. 11000 nebo 110 00).';
if (!$error && strlen($shipping_city) < 2) $error = 'Zadejte město (alespoň 2 znaky).';
if (!$error && !preg_match('/^\d{9}$/', $shipping_phone)) $error = 'Zadejte telefon ve tvaru 123456789 (9 číslic bez mezer).';
if (!$error && !filter_var($user_email, FILTER_VALIDATE_EMAIL)) $error = 'Zadejte platný e-mail.';

if ($error) {
    header('Location: ../../pages/checkout.php?error=' . urlencode($error));
    exit;
}

// ULOŽIT fakturační údaje zpět do user profilu - pokud se změnily
$usersDB->updateProfileWithAddress(
    $userId,
    $user['name'],
    $user['avatar'],
    $shipping_name,
    $shipping_street,
    $shipping_postal_code,
    $shipping_city,
    $shipping_phone
);

// Vložení objednávky do DB
$pdo = $usersDB->getPdo();

// Vložení do tabulky orders
$stmt = $pdo->prepare("INSERT INTO orders (user_id, date, status, shipping_address) VALUES (?, NOW(), 'nová', ?)");
$shipping_data = json_encode([
    'name' => $shipping_name,
    'street' => $shipping_street,
    'postal_code' => $shipping_postal_code,
    'city' => $shipping_city,
    'phone' => $shipping_phone,
    'email' => $user_email,
    'shipping_method' => $shipping_method,
    'payment_method' => $payment_method,
]);
$stmt->execute([$userId, $shipping_data]);
$order_id = $pdo->lastInsertId();

// Vložení položek z košíku do order_items
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $qty) {
        $stmtProd = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmtProd->execute([$productId]);
        $product = $stmtProd->fetch();

        $price = $product ? $product['price'] : 0;

        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, game_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $order_id,
            $productId,
            $qty,
            $price,
        ]);
    }
}

unset($_SESSION['cart']);

// ODESLAT EMAIL
$to = $user_email;
$subject = "Objednávka číslo: $order_id";
$message = "Děkujeme za objednání.";
$headers = "From: Deskovkárna <noreply@deskovkarna.cz>\r\n";
mail($to, $subject, $message, $headers);

header('Location: ../../pages/order-confirmation.php?order=' . $order_id);
exit;

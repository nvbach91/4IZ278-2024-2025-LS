<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../database-config/UsersDB.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=Pro pokračování je nutné se přihlásit.');
    exit;
}

$userId = $_SESSION['user_id'];
$usersDB = new UsersDB();
$user = $usersDB->findById($userId);

$shipping_name = htmlspecialchars($_GET['shipping_name'] ?? ($user['shipping_name'] ?? ''));
$shipping_street = htmlspecialchars($_GET['shipping_street'] ?? ($user['shipping_street'] ?? ''));
$shipping_postal_code = htmlspecialchars($_GET['shipping_postal_code'] ?? ($user['shipping_postal_code'] ?? ''));
$shipping_city = htmlspecialchars($_GET['shipping_city'] ?? ($user['shipping_city'] ?? ''));
$shipping_phone = htmlspecialchars($_GET['shipping_phone'] ?? ($user['shipping_phone'] ?? ''));
$user_email = htmlspecialchars($_GET['user_email'] ?? ($user['email'] ?? ''));

$shipping_method = htmlspecialchars($_GET['shipping_method'] ?? '');
$payment_method = htmlspecialchars($_GET['payment_method'] ?? '');

$dopravy = [
    'ceska_posta' => 'Česká pošta',
    'zasilkovna' => 'Zásilkovna',
    'osobni_odber' => 'Osobní odběr',
];
$platby = [
    'prevod' => 'Bankovní převod',
    'dobirka' => 'Dobírka',
    'online' => 'Online kartou',
];

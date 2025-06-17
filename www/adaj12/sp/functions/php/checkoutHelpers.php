<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../database-config/UsersDB.php';

// Ověření přihlášení uživatele
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=Pro pokračování je nutné se přihlásit.');
    exit;
}

$userId = $_SESSION['user_id'];
$usersDB = new UsersDB();
$user = $usersDB->findById($userId);

// Fakturační údaje z DB nebo prázdné řetězce
$shipping_name = htmlspecialchars($user['shipping_name'] ?? '');
$shipping_street = htmlspecialchars($user['shipping_street'] ?? '');
$shipping_postal_code = htmlspecialchars($user['shipping_postal_code'] ?? '');
$shipping_city = htmlspecialchars($user['shipping_city'] ?? '');
$shipping_phone = htmlspecialchars($user['shipping_phone'] ?? '');
$user_email = htmlspecialchars($user['email'] ?? '');

// Dopravní možnosti a platby
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

<?php
// sp/google_callback.php

session_start();
require_once __DIR__ . '/database/db-config.php';
require_once __DIR__ . '/database/db-connection.php';
require_once __DIR__ . '/database/User.php';
require_once __DIR__ . '/database/Auth.php';

use App\DatabaseConnection;
use App\User;
use App\Auth;

// 1) Zkontrolovat stav (CSRF protection)
if (
    empty($_GET['state'])
    || !hash_equals($_SESSION['oauth2state'] ?? '', $_GET['state'])
) {
    unset($_SESSION['oauth2state']);
    exit('Neplatný stav OAuth2.');
}

// 2) Vyměnit authorization code za access token
$tokenUrl = 'https://oauth2.googleapis.com/token';
$data = [
  'code'          => $_GET['code'] ?? '',
  'client_id'     => GOOGLE_CLIENT_ID,
  'client_secret' => GOOGLE_CLIENT_SECRET,
  'redirect_uri'  => GOOGLE_REDIRECT_URI,
  'grant_type'    => 'authorization_code'
];

$ch = curl_init($tokenUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$response = curl_exec($ch);
curl_close($ch);

$token = json_decode($response, true);
if (empty($token['access_token'])) {
    exit('Chyba při získávání access tokenu.');
}

// 3) Načíst data uživatele
$userinfo = json_decode(
    file_get_contents(
        'https://www.googleapis.com/oauth2/v3/userinfo?access_token='
        . $token['access_token']
    ),
    true
);

$email = $userinfo['email'] ?? '';
$name  = $userinfo['name']  ?? '';
if (!$email) {
    exit('Nepodařilo se získat e-mail z Google.');
}

// 4) Najít nebo vytvořit uživatele v DB
$pdo       = DatabaseConnection::getPDOConnection();
$userModel = new User($pdo);

if (!$userModel->exists($email)) {
    // vkládáme náhodné heslo, už nebude třeba
    $userModel->create($name, $email, bin2hex(random_bytes(16)));
}

// 5) Přihlásit uživatele
$auth = new Auth($pdo);
if (!$auth->loginByEmail($email)) {
    exit('Chyba při přihlašování uživatele.');
}

// 6) Hotovo – přesměrovat na dashboard
header('Location: dashboard.php');
exit;

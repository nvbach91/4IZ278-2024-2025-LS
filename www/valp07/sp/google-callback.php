<?php
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/db.php';

session_start();

$client = new Google_Client();
$client->setClientId('');
$client->setClientSecret('');
$client->setRedirectUri('http://localhost/www/valp07/sp/google-callback.php');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
        exit('Failed to get access token: ' . htmlspecialchars($token['error']));
    }
    $client->setAccessToken($token);

    $oauth = new Google_Service_Oauth2($client);
    $google_user = $oauth->userinfo->get();

    $email = $google_user->email;
    $name = $google_user->name;
    $db = new PDO(
        'mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE . ';charset=utf8mb4',
        DB_USERNAME,
        DB_PASSWORD
    );

    $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $stmt = $db->prepare('INSERT INTO users (email, password_hash) VALUES (:email, NULL)');
        $stmt->execute(['email' => $email]);
        $userId = $db->lastInsertId();
    } else {
        $userId = $user['id'];
    }

    $_SESSION['id'] = $userId;
    $_SESSION['user_email'] = $email;

    header('Location: index.php');
    exit;
} else {
    exit('Invalid OAuth callback');
}

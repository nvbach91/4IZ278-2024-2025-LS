<?php

require_once __DIR__ . '/../app/models/UserDB.php';
$config = require __DIR__ . "/../config/oauth_config.php";

session_start();

if (!isset($_GET['code'])) {
    die('Authorization code not found.');
}

$code = $_GET['code'];

$response = file_get_contents('https://oauth2.googleapis.com/token', false, stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query([
            'code' => $code,
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'redirect_uri' => $config['redirect_uri'],
            'grant_type' => 'authorization_code'
        ])
    ]
]));

if (!$response) {
    die('Failed to fetch token.');
}

$data = json_decode($response, true);

$access_token = $data['access_token'] ?? null;

if (!$access_token) {
    die('Access token not received.');
}

$user_response = file_get_contents('https://www.googleapis.com/oauth2/v3/userinfo?access_token=' . $access_token);
$user_info = json_decode($user_response, true);

$userDB = new UserDB();
$existing = $userDB->fetchByEmail($user_info['email']);

if (!$existing) {
    $userDB->insert([
        'email' => $user_info['email'],
        'password' => '',
        'is_verified' => 1
    ]);

    $existing = $userDB->fetchByEmail($user_info['email']);
}

$_SESSION['user_id'] = $existing['user_id'];
$_SESSION['email'] = $existing['email'];
$_SESSION['privilege'] = $existing['privilege'];

header("Location: /~zemo00/sp/home");
exit;


?>
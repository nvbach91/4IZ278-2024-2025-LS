<?php

require_once __DIR__ . "/../app/models/UserDB.php";

$userDB = new UserDB();

$token = $_GET['token'] ?? '';

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    if ($token) {
        $user = $userDB->fetchWhere(['verification_token' => $token], ['user_id', 'token_created_at', 'email'])[0] ?? null;
        echo 'user:' . var_dump($user);
        if ($user) {
            echo 'user exists';
            $tokenAge = time() - strtotime($user['token_created_at']);
            if ($tokenAge < 600) {
                $userDB->verify($user['email']);
                echo 'user is verified';
                $result = 'success';
            } else {
                $result = 'expired';
            }
        }
    } else {
        $result = 'no-token';
    }
}

require __DIR__ . "/../app/views/pages/verification_page.php";


?>
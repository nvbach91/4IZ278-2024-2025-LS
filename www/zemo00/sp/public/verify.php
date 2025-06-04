<?php

require_once __DIR__ . "/../app/models/UserDB.php";

$userDB = new UserDB();

$token = $_GET['token'] ?? '';

if ($token) {
    $user = $userDB->fetchWhere(['verification_token' => $token], ['user_id', 'token_created_at', 'email'])[0] ?? null;
    if ($user) {
        $tokenAge = time() - strtotime($user['token_created_at']);
        if ($tokenAge < 600) {
            $userDB->verify($user['email']);
            $url = BASE_URL . "/login";
            header("Location: $url");
            exit;
        } else {
            echo "Token expired";
        }
    }
} else {
    echo "No verification token provided";
}
$url = BASE_URL . "/login";
header("Location: $url");
exit;

?>
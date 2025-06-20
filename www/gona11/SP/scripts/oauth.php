<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database/DB_Scripts/UserDB.php';
session_start();

$provider = new League\OAuth2\Client\Provider\Google([
    'clientId' => '67669618114-q3on9t47op73vml0jgptr2u1mjkq8c6j.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => 'https://eso.vse.cz/~gona11/SP/scripts/oauth.php',
]);

if (!isset($_GET['code'])) {
    exit('Přístup byl zamítnut.');
}

try {
    $token = $provider->getAccessToken("authorization_code", [
        "code" => $_GET["code"]
    ]);

    $user = $provider->getResourceOwner($token)->toArray();
    $email = $user["email"];
    $name = $user["name"];
    $oauthId = $user["sub"];
    $oauthProvider = "google";

    $userDB = new UserDB();
    $existingUser = $userDB->findByOAuth($oauthProvider, $oauthId);

    if (!$existingUser) {
        $userDB->createOAuth($email,$name,$oauthProvider,$oauthId);
        $existingUser = $userDB->findByOAuth($oauthProvider, $oauthId);
    }

        $_SESSION["privilege"] = $existingUser["privilege_level"];
        $_SESSION["user_id"] = $existingUser["id_user"];
        setcookie("loginSuccess", $email, time() + 3600, "/");

    header('Location: ../index.php');
    exit;

} catch (\Exception $e) { 
    exit('Přihlášení selhalo: ' . $e->getMessage());
}
?>
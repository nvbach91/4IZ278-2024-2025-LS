<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
$provider = new League\OAuth2\Client\Provider\Google([
    "clientId" => "67669618114-q3on9t47op73vml0jgptr2u1mjkq8c6j.apps.googleusercontent.com",
    "clientSecret" => "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",
    "redirectUri"  => "https://eso.vse.cz/~gona11/SP/scripts/oauth.php",
]);

$authUrl = $provider->getAuthorizationUrl();
$_SESSION["oauth2state"] = $provider->getState();

header('Location: ' . $authUrl);
exit; ?>
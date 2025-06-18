<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
$provider = new League\OAuth2\Client\Provider\Google([
    "clientId" => "67669618114-15viag075ch0gs1fb5rvt09cc36ajhst.apps.googleusercontent.com",
    "clientSecret" => "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",
    "redirectUri"  => "http://localhost/www/gona11/SP/scripts/oauth.php",
]);

$authUrl = $provider->getAuthorizationUrl();
$_SESSION["oauth2state"] = $provider->getState();

header('Location: ' . $authUrl);
exit; ?>
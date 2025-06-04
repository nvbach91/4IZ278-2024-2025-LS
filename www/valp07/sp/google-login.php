<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('1028430425655-4ujjsf20cknuattf7otjan0n3ptt3bkh.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/www/valp07/sp/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

$login_url = $client->createAuthUrl();

header('Location: ' . filter_var($login_url, FILTER_SANITIZE_URL));
exit;

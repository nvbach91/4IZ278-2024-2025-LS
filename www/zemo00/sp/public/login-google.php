<?php

$config = require __DIR__ . "/../config/oauth_config.php";

$params = http_build_query([
    'client_id' => $config['client_id'],
    'redirect_uri' => $config['redirect_uri'],
    'response_type' => 'code',
    'scope' => 'email profile',
    'access_type' => 'online',
    'prompt' => 'consent'
]);

header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . $params);
exit;

?>
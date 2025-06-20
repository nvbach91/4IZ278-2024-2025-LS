<?php
// sp/google_login.php

session_start();
require_once __DIR__ . '/database/db-config.php';

$state = bin2hex(random_bytes(16));
$_SESSION['oauth2state'] = $state;

$params = [
  'response_type' => 'code',
  'client_id'     => GOOGLE_CLIENT_ID,
  'redirect_uri'  => GOOGLE_REDIRECT_URI,
  'scope'         => 'openid email profile',
  'state'         => $state,
  'access_type'   => 'offline',
  'prompt'        => 'select_account'
];

$authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
header('Location: ' . $authUrl);
exit;

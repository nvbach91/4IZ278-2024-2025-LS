<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';


use JanuSoftware\Facebook\Facebook;
use JanuSoftware\Facebook\Exception\ResponseException;
use JanuSoftware\Facebook\Exception\SDKException;



// Facebook OAuth Configuration
define('FACEBOOK_APP_ID', ''); // Replace with your App ID
define('FACEBOOK_APP_SECRET', ''); // Replace with your App Secret
define('FACEBOOK_REDIRECT_URI', SITE_URL . 'facebook_callback.php');


// Facebook OAuth Scopes
define('FACEBOOK_SCOPES', [
    'email',
    'public_profile'
]);

// Initialize Facebook SDK
$fb = new Facebook([
    'app_id' => FACEBOOK_APP_ID,
    'app_secret' => FACEBOOK_APP_SECRET,
    'default_graph_version' => 'v18.0'
]);

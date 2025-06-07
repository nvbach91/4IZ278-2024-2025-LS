<?php
session_start();
require 'vendor/autoload.php';
require_once __DIR__ . '/models/User.php';

use League\OAuth2\Client\Provider\Google;

// Replace these with your Google client ID and secret
$client_id = '';
$client_secret = '';

$provider = new Google([
    'clientId' => $client_id,
    'clientSecret' => $client_secret,
    'redirectUri' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
        . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?'),
    'scope' => ['email', 'profile']
]);

// Generate authorization URL and redirect the user to it
if (!isset($_GET['code'])) {
    $auth_url = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $auth_url);
    exit;
}

// Check the state parameter and exchange the authorization code for an access token
if (isset($_GET['state']) && $_GET['state'] === $_SESSION['oauth2state']) {
    try {
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code'],
        ]);        // Use the access token to retrieve user information
        $googleUser = $provider->getResourceOwner($token);
        
        // Get user data - these are the correct method names for Google provider
        $userData = $googleUser->toArray();
        $email = $userData['email'];
        $name = $userData['name'];
        $googleId = $userData['sub'];
        
        // check if user exists or create new user
        $user = new User();
        $existingUser = $user->findByEmail($email);
        
        if ($existingUser) {
            // user exists, log them in
            $_SESSION['user_id'] = $existingUser['id'];
            $_SESSION['username'] = $existingUser['username'];
            $_SESSION['email'] = $existingUser['email'];
            $_SESSION['role'] = $existingUser['role'];
            $_SESSION['logged_in'] = true;
        } else {
            // create new user
            $username = $name ?: explode('@', $email)[0]; // Use name or email prefix as username
            if ($user->registerGoogleUser($username, $email, $googleId)) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['email'] = $user->email;
                $_SESSION['role'] = 'user';
                $_SESSION['logged_in'] = true;
            } else {
                die('Error creating user account');
            }
        }
        
        header('Location: ./');
        exit;
        
    } catch (Exception $e) {
        die('OAuth error: ' . $e->getMessage());
    }
} else {
    die('Invalid OAuth state');
}
?>
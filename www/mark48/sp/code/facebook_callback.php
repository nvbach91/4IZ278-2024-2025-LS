<?php
session_start();
require_once 'includes/init.php';
require_once 'includes/facebook_config.php';
require_once 'vendor/autoload.php';

use JanuSoftware\Facebook\Facebook;
use JanuSoftware\Facebook\Exception\ResponseException;
use JanuSoftware\Facebook\Exception\SDKException;

// Initialize Facebook SDK
$fb = new Facebook([
    'app_id' => FACEBOOK_APP_ID,
    'app_secret' => FACEBOOK_APP_SECRET,
    'default_graph_version' => 'v18.0'
]);

// Handle the OAuth callback
try {
    $helper = $fb->getRedirectLoginHelper();

    // Handle "state" parameter that Facebook sends back
    $_SESSION['FBRLH_state'] = $_GET['state'];

    // Get access token
    $accessToken = $helper->getAccessToken();

    if (!$accessToken) {
        // Check for errors
        if ($helper->getError()) {
            throw new Exception(
                'Facebook Error: ' . $helper->getError() . "\n" .
                    'Error Code: ' . $helper->getErrorCode() . "\n" .
                    'Error Reason: ' . $helper->getErrorReason() . "\n" .
                    'Error Description: ' . $helper->getErrorDescription()
            );
        }
        throw new Exception('Bad request');
    }

    // Get user data
    $response = $fb->get('/me?fields=id,name,email', $accessToken);
    $user = $response->getGraphNode();

    // Extract user information
    $facebookId = $user->getField('id');
    $name = $user->getField('name');
    $email = $user->getField('email');

    // Initialize user model
    $userModel = new UserDb();

    // First check if user exists with this Facebook ID
    $existingUser = $userModel->getUserByFacebookId($facebookId);

    if ($existingUser) {
        // User exists - log them in
        $_SESSION['user_id'] = $existingUser->id;
        $_SESSION['user_email'] = $existingUser->email;
        $_SESSION['user_name'] = $existingUser->name;
        $_SESSION['user_role'] = $existingUser->role_name;

        setFlashMessage('success', 'You have been successfully logged in with Facebook.');
        redirect(SITE_URL);
    } else {
        // If not found by Facebook ID, check by email
        $existingUser = $userModel->getUserByEmail($email);

        if ($existingUser) {
            // User exists but doesn't have Facebook ID, update it
            $existingUser->facebook_id = $facebookId;
            $userModel->updateUser($existingUser);

            $_SESSION['user_id'] = $existingUser->id;
            $_SESSION['user_email'] = $existingUser->email;
            $_SESSION['user_name'] = $existingUser->name;
            $_SESSION['user_role'] = $existingUser->role_name;

            setFlashMessage('success', 'You have been successfully logged in with Facebook.');
            redirect(SITE_URL);
        } else {
            // Create new user
            $userData = [
                'email' => $email,
                'name' => $name,
                'facebook_id' => $facebookId,
                'password' => bin2hex(random_bytes(16)) // Random password for OAuth users
            ];

            $userModel->createUser($userData);
            $newUser = $userModel->getUserByEmail($email);

            $_SESSION['user_id'] = $newUser->id;
            $_SESSION['user_email'] = $newUser->email;
            $_SESSION['user_name'] = $newUser->name;
            $_SESSION['user_role'] = $newUser->role_name;

            setFlashMessage('success', 'Your account has been created and you have been logged in with Facebook.');
            redirect(SITE_URL);
        }
    }
} catch (ResponseException $e) {
    // When Graph returns an error
    $_SESSION['login_error'] = 'Facebook Graph returned an error: ' . $e->getMessage();
    redirect('login.php');
} catch (SDKException $e) {
    // When validation fails or other local issues
    $_SESSION['login_error'] = 'Facebook SDK returned an error: ' . $e->getMessage();
    redirect('login.php');
} catch (Exception $e) {
    $_SESSION['login_error'] = 'An error occurred: ' . $e->getMessage();
    redirect('login.php');
}

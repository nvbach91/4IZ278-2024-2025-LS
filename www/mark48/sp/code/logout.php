<?php

/**
 * Logout page
 */

// Initialize the application
require_once 'includes/init.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    redirect(SITE_URL);
}

// Initialize models
$userModel = new UserDb();

// Log out the user
$userModel->logout();

// Set flash message and redirect
setFlashMessage('success', 'You have been successfully logged out.');
redirect(SITE_URL);

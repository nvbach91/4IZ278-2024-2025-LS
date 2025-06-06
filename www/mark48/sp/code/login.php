<?php

/**
 * Login page
 */

// Initialize the application
require_once 'includes/init.php';
require_once 'includes/facebook_config.php';
require_once 'vendor/autoload.php';

use JanuSoftware\Facebook\Facebook;

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(SITE_URL);
}

// Initialize Facebook SDK
$fb = new Facebook([
    'app_id' => FACEBOOK_APP_ID,
    'app_secret' => FACEBOOK_APP_SECRET,
    'default_graph_version' => 'v12.0'
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Add any additional permissions you need
$fbLoginUrl = $helper->getLoginUrl(FACEBOOK_REDIRECT_URI, $permissions);

// Initialize models
$userModel = new UserDb();

// Process form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!checkCSRFToken()) {
        $errors[] = 'Invalid form submission.';
    } else {
        // Get form data
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validate form data
        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (empty($password)) {
            $errors[] = 'Password is required.';
        }

        // Attempt login if no validation errors
        if (empty($errors)) {
            if ($userModel->login($email, $password)) {
                // Login successful
                setFlashMessage('success', 'You have been successfully logged in.');
                redirect(SITE_URL);
            } else {
                $errors[] = 'Invalid email or password.';
            }
        }
    }
}

// Check if there's a login error message
$error_message = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Login</h2>
                </div>
                <div class="card-body">
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                    <?php endif; ?>

                    <?php displayErrors($errors); ?>

                    <form method="post" action="login.php">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($email) ? escape($email) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <p class="text-center">Or login with:</p>
                        <div class="text-center">
                            <a href="<?php echo htmlspecialchars($fbLoginUrl); ?>" class="btn btn-primary">
                                <i class="fab fa-facebook"></i> Login with Facebook
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="mb-0">Don't have an account? <a href="register.php">Register here</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include the footer
include 'views/footer.php';
?>
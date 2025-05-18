<?php

/**
 * Registration page
 */

// Initialize the application
require_once 'includes/init.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(SITE_URL);
}

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
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validate form data
        if (empty($name)) {
            $errors[] = 'Name is required.';
        }

        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (empty($password)) {
            $errors[] = 'Password is required.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match.';
        }

        // Register user if no validation errors
        if (empty($errors)) {
            $userId = $userModel->register($name, $email, $password);

            if ($userId) {
                // Registration successful, log user in
                $userModel->login($email, $password);
                setFlashMessage('success', 'You have been successfully registered and logged in.');
                redirect(SITE_URL);
            } else {
                $errors[] = 'Email address is already registered.';
            }
        }
    }
}

// Include the header
include 'views/header.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Register</h2>
                </div>
                <div class="card-body">
                    <?php displayErrors($errors); ?>

                    <form method="post" action="register.php">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? escape($name) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($email) ? escape($email) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <p class="mb-0">Already have an account? <a href="login.php">Login here</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include the footer
include 'views/footer.php';
?>
<!DOCTYPE html>
<?php
include __DIR__ . '/partial/head.php';
?>

<body>
    <div class="container">
        <!-- Header and navigation-->
        <?php
        include __DIR__ . '/partial/header.php';
        include __DIR__ . '/partial/navigation.php';
        ?>

        <!-- login form -->
        <main class="main-content">
            <div class="auth-container">
                <div class="auth-form">
                    <h2>Sign in to your account</h2>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-error">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="./login">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full">Sign In</button>
                    </form>
                    
                    <div class="oauth-buttons">
                        <a href="./oauth.php" class="btn btn-google">
                            <img src="./assets/google_logo.png" alt="Google Logo" style="height:20px;vertical-align:middle;margin-right:8px;">
                            Log in with Google
                        </a>
                    </div>
                    
                    <div class="auth-links">
                        <a href="./register">Create account</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php
    include __DIR__ . '/partial/footer.php';
    ?>
    <script src="script/main.js"></script>
</body>

</html>
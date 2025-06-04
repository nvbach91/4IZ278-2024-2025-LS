<!DOCTYPE html>
<?php
include __DIR__ . '/partial/head.php';
?>

<body>
    <div class="container">
        <?php
        include __DIR__ . '/partial/header.php';
        include __DIR__ . '/partial/navigation.php';
        ?>
        
        <!-- reg form -->
        <main class="main-content">
            <div class="auth-container">
                <div class="auth-form">
                    <h2>Create Your Account</h2>
                    <p>Join RecipeHub to save your favorite recipes and create your own!</p>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-error">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($success); ?>
                            <a href="./login">Click here to login</a>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="./register">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" required 
                                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required minlength="6">
                            <small>Password must be at least 6 characters long</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-full">Create Account</button>
                    </form>
                    
                    <div class="auth-links">
                        <p>Already have an account? <a href="./login">Login here</a></p>
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
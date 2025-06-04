<?php require __DIR__ . '/../incl/header.php'; ?>
<main class="container">
    <h1>Login</h1>
    <form method="POST">
        <div class="form-group">
            <label for="name">E-mail</label>
            <input class="form-control" id="email" name="email" placeholder="E-mail">
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="mt-3">
        <a class="btn btn-danger" href="google-login.php">Login with Google</a>
    </div>
    <div class="mt-3">
        <a class="btn btn-danger" href="requestReset.php">Reset Password</a>
    </div>
</main>
<?php require __DIR__ . '/../incl/footer.php'; ?>
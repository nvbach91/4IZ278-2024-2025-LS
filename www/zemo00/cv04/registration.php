<?php require __DIR__ . "/utilities/validation.php"; ?>
<?php include __DIR__ . "/includes/head.html";?>


<h1>Registration</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <?php foreach($errors as $error): ?>
        <div class="alert-danger"><?php echo $error; ?></div>
    <?php endforeach; ?>
    <?php if (isset($successMessage)): ?>
        <div class="success"><?php echo $successMessage;?></div>
    <?php endif; ?>
    <div>
        <label for="username">Name</label>
        <input id="username" name="username"
            value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>"
        >
    </div>
    <div>
        <label for="email">E-mail</label>
        <input id="email" name="email"
            value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>"
        >
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" name="password">
    </div>
    <div>
        <label for="password2">Confirm password</label>
        <input type="password" name="password2">
    </div>
    <button type="submit">Submit</button>
</form>



<?php include __DIR__ . "/includes/foot.html";?>
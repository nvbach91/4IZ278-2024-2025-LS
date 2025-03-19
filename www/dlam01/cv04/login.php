<?php require __DIR__ . "/loginForm.php" ?>
<?php include __DIR__ . "/includes/header.php"; ?>
<form action=<?php echo $_SERVER['PHP_SELF'] ?> method="POST" class="form-register">
    <h1>Player login</h1>
    <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($errors["email"])): ?>
        <div class='alert alert-danger' role='alert'>
            <?php echo $errors["email"]; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label class="form-label">Email address*</label>
        <input name="email" class="form-control" aria-describedby="emailHelp"
            value="<?php echo isset($email) ? $email : "" ?>">
        <div id="emailHelp" class="form-text">Enter a valid email address e.g. pepa@gmail.com</div>
    </div>

    <?php if (isset($errors["password"])): ?>
        <div class='alert alert-danger' role='alert'>
            <?php echo $errors["password"]; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label class="form-label">Password*</label>
        <input name="password" class="form-control" aria-describedby="password" type="password">
        <div id="emailHelp" class="form-text">Enter a password</div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
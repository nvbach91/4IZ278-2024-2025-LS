<?php
require './functions/validate.php';
?>

<?php if ($successMessage): ?>
    <div class="alert alert-success"><?php echo $successMessage; ?></div>
<?php endif; ?>
<form class="form-signup" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label>Name*</label>
        <input class="form-control" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
        <small class="form-text text-muted">example: Jakub Adam</small>
        <div class="text-danger"><?php echo htmlspecialchars($nameErr); ?></div>
    </div>
    <div class="form-group">
        <label>Email*</label>
        <input class="form-control" type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
        <small class="form-text text-muted">example: jakub.adam@gmail.com</small>
        <div class="text-danger"><?php echo $emailErr; ?></div>
    </div>
    <div class="form-group">
        <label>Password*</label>
        <input class="form-control" type="password" name="password">
        <div class="text-danger"><?php echo $passwordErr; ?></div>
    </div>
    <div class="form-group">
        <label>Confirm Password*</label>
        <input class="form-control" type="password" name="confirm_password">
        <div class="text-danger"><?php echo $confirmPasswordErr; ?></div>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>
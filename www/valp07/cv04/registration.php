<?php

require __DIR__ . '/utils/utils.php';

$messages = [];
$invalidInputs = [];



$isSubmitted = !empty($_POST);

if ($isSubmitted) {
    $password = htmlspecialchars(trim($_POST['password']));
    $passwordRepeat = htmlspecialchars(trim($_POST['passwordRepeat']));
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));

    if (!$name) {
        $messages['name'] = 'Please enter a name';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messages['email'] = 'Please enter a valid email';
    }
    if (!$password) {
        $messages['password'] = 'Please enter a password';
    }
    if ($password != $passwordRepeat) {
        $messages['passwordRepeat'] = 'Passwords do not match';
    }
    if (!$messages) {
        if(registerNewUser($password, $name, $email)) {
            $messages['success'] = 'User successfully registered';
            $headers  = "From: sender@example.com\r\n";
            $headers .= "Reply-To: reply@example.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            mail($email, 'Registration Successful', 'You have registered at cv04 successfully', $headers);
            
        } else {
            $messages['email'] = 'Email already exists';
        }
        
    }
}

?>
<?php include './includes/header.php'; ?>
<main class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-signup" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2 class="text-center">Signup Form</h2>
                <?php if (isset($messages['success'])): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($messages['success']); ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control<?php echo in_array('name', $invalidInputs) ? ' is-invalid' : '' ?>" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : '' ?>">
                    <small class="text-muted">Format: John Cena</small>
                    <?php if (isset($messages['name'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['name']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control<?php echo in_array('email', $invalidInputs) ? ' is-invalid' : '' ?>" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : '' ?>">
                    <small class="text-muted">Format: example@email.com</small>
                    <?php if (isset($messages['email'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['email']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control<?php echo in_array('password', $invalidInputs) ? ' is-invalid' : '' ?>" name="password" type="password">
                    <?php if (isset($messages['password'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['password']); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Repeat Password</label>
                    <input class="form-control<?php echo in_array('passwordRepeat', $invalidInputs) ? ' is-invalid' : '' ?>" name="passwordRepeat" type="password">
                    <?php if (isset($messages['passwordRepeat'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($messages['passwordRepeat']); ?></div>
                    <?php endif; ?>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Submit</button>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
<?php include './includes/footer.php'; ?>
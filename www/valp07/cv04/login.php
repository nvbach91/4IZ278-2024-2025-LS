<?php

require __DIR__ . '/utils/utils.php';

$messages = [];
$invalidInputs = [];
$submittedForm = !empty($_POST);
if ($submittedForm) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $user = fetchUser($email);
    if ($user && $user['password'] == $password) {
        header('Location: profile.php?email=' . $email);
        exit();
    } else {
        $messages['error'] = 'Invalid email or password';
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
                <?php if (isset($messages['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($messages['error']); ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control<?php echo in_array('email', $invalidInputs) ? ' is-invalid' : '' ?>" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : '' ?>">
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
                <button class="btn btn-primary btn-block" type="submit">Submit</button>
            </form>

        </div>
    </div>
</main>
<?php include './includes/footer.php'; ?>
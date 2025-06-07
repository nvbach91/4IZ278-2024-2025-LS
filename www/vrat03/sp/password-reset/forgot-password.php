<?php require_once __DIR__ .'/../vendor/autoload.php'; ?>
<?php require __DIR__.'/../utils/Validator.php';?>
<?php require __DIR__.'/../utils/Email.php';?>
<?php require_once __DIR__.'/../utils/Logger.php';?>
<?php require_once __DIR__.'/../database/UsersDB.php';?>
<?php require __DIR__.'/../database/PasswordResetDB.php';?>
<?php
if(!isset($_SESSION)) {   
    session_start();        
}
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$validator = new Validator();
$emailClient = new Email();
$log = AppLogger::getLogger();
$usersDB = new UsersDB();
$passwordResetDB = new PasswordResetDB();
$errors = [];

if (isset($_SESSION['user'])) {
    $errors['alert'] = 'You are already logged in. Please log out first if you want to reset your password.';
}
if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on register.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {   
        $email = htmlspecialchars(trim($_POST['email'])); 
        $validator->validateEmail('email', $email);

        if(!$validator->hasErrors()) {
            $existingUser = $usersDB->fetchUserByEmail($email);
            if (!$existingUser) {
                $errors['alert'] = 'Email does not exist';
            } else if ($existingUser['password'] == null){
                $errors['email'] = 'This email is not registered with a password. Please use the Google login option.';
            } else {
                $resetToken = bin2hex(random_bytes(32));
                $expires = date("Y-m-d H:i:s", time() + 900);
                $passwordResetDB->storePasswordResetToken($existingUser['user_id'], $resetToken, $expires);
                $resetLink = 'password-reset/reset-password.php?token=' . $resetToken;
                $log->info('Password reset requested', [
                    'user_id' => $existingUser['user_id'],
                    'email' => $email,
                    //'reset_link' => $resetLink
                ]);

                if ($emailClient->sendPasswordReset($email, $resetLink)) {
                    $errors['success'] = 'Password reset email sent successfully. Please check your inbox.';
                } else {
                    $errors['alert'] = 'Failed to send password reset email. Please try again later.';
                }
            }
        } else {
            $errors = $validator->getErrors();
        }
    }
}

?>

<?php require __DIR__.'/../includes/head.php';?>
<div class="container">
    <h1 class="my-4">Forgot password</h1>
    <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['success']; ?>
    </div>
    <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['alert']; ?>
    </div>

    <form method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">

        <?php $csrf->insertToken(); ?>

        <div id="alertEmail" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['email']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['email']; ?>
        </div>
        <div class="mb-3">
            <label for="email">*Email:</label>
            <input id="email" name="email" class="form-control" value="<?php echo isset($email) ? $email : ''?>">
        </div>

        <button type="submit" id="submitButton" class="btn btn-primary" <?php echo isset($errors['success'])||isset($errors['alert']) ? 'disabled' : ''; ?>>
            Reset
        </button>
    </form>
</div>

<script type="module" src="../js/forgot-password.js"></script>
<?php require __DIR__.'/../includes/foot.php';?>
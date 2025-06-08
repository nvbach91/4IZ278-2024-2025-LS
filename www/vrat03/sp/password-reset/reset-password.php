<?php require __DIR__.'/../prefix.php';?>
<?php require_once __DIR__ .'/../vendor/autoload.php'; ?>
<?php require __DIR__.'/../utils/Validator.php';?>
<?php require_once __DIR__.'/../utils/Logger.php';?>
<?php require_once __DIR__.'/../database/UsersDB.php';?>
<?php require_once __DIR__.'/../database/PasswordResetDB.php';?>
<?php

if(!isset($_SESSION)) {   
    session_start();        
}
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$validator = new Validator();
$log = AppLogger::getLogger();
$usersDB = new UsersDB();
$passwordResetDB = new PasswordResetDB();
$errors = [];

if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on register.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {
        $token = isset($_POST['token']) ? htmlspecialchars(trim($_POST['token'])) : '';
        $resetRequest = $passwordResetDB->fetchPasswordResetByToken($token);

        if ($resetRequest && $resetRequest['expires'] > date('Y-m-d H:i:s')) {
            $newPassword = trim($_POST['newPassword']);
            $newPassword2 = trim($_POST['newPassword2']); 
            
            $validator->validatePassword('newPassword', $newPassword, $newPassword2);

            if(!$validator->hasErrors()) {
                $userId = $resetRequest['user_id'];
                $existingUser = $usersDB->fetchUserById($userId);

                if (!$existingUser) {
                    $errors['alert'] = 'User does not exist';
                } else if ($existingUser['password'] == null){
                    $errors['alert'] = 'This account is not registered with a password. Please use the Google login option.';
                } else {
                    $usersDB->updateUserPassword($userId, $newPassword);
                    $passwordResetDB->deletePasswordResetByToken($token);

                    $log->info('Password reset successful', [
                        'user_id' => $userId,
                        'ip' => $_SERVER['REMOTE_ADDR']
                    ]);
                    $errors['success'] = 'Password has been reset successfully. You can now <a href="'.$urlPrefix.'/login.php">log in</a> with your new password.';
                }
            } else {
                $errors = $validator->getErrors();
            }
        } else {
            $errors['alert'] = 'Invalid or expired password reset token.';
        }
    } 
} else if(!isset($_GET['token']) || empty($_GET['token'])) {
    header('Location: '.$urlPrefix.'/index.php');
    exit();
}

?>

<?php require __DIR__.'/../includes/head.php';?>
<div class="container">
    <h1 class="my-4">Password reset</h1>

    <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['success']; ?>
    </div>
    <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['alert']; ?>
    </div>

    <form method='POST' action="reset-password.php?token=<?php echo urlencode($_GET['token']); ?>">

        <?php $csrf->insertToken(); ?>
        <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : (isset($_POST['token']) ? htmlspecialchars($_POST['token']) : ''); ?>">
        <div id="alertNewPassword" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['newPassword']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['newPassword']; ?>
        </div>
        <div class="mb-3">
            <label for="newPassword">*New password:</label>
            <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="At least 8 characters">
        </div>

        <div id="alertNewPassword2" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['newPassword2']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['newPassword2']; ?>
        </div>
        <div class="mb-3">
            <label for="newPassword2" class="form-label">*Enter new password one more time</label>
            <input type="password" id="newPassword2" name="newPassword2" class="form-control">
        </div>

        <button type="submit" id="submitButton" class="btn btn-primary" <?php echo isset($errors['success'])||isset($errors['alert']) ? 'disabled' : ''; ?>>
            Reset
        </button>
    </form>
</div>

<script type="module" src="../js/reset-password.js"></script>
<?php require __DIR__.'/../includes/foot.php';?>
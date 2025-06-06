<?php require_once __DIR__ . '/prefix.php'; ?>
<?php require_once __DIR__ .'/vendor/autoload.php'; ?>
<?php require __DIR__.'/utils/Validator.php';?>
<?php require_once __DIR__.'/privileges.php';?>
<?php require_once __DIR__.'/database/UsersDB.php';?>
<?php require_once __DIR__ . '/utils/Logger.php'; ?>
<?php
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$usersDB = new UsersDB();
$log = AppLogger::getLogger();
$errors = [];


$userId = $_SESSION['user']['id'];
$user = $usersDB->fetchUserById($userId);
$email = $user['email'];
$currentPassword = $user['password'];

if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on account-reset-passwd.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {
        $validator = new Validator();
        $currentPassword = htmlspecialchars(trim($_POST['currentPassword']));
        $newPassword = htmlspecialchars(trim($_POST['newPassword']));
        $newPassword2 = htmlspecialchars(trim($_POST['newPassword2'])); 

        $validator->validateCurrentPassword('currentPassword', $currentPassword);
        $validator->validatePassword('newPassword', $newPassword, $newPassword2);

        if(!$validator->hasErrors()) {
            $usersDB->updateUserPassword($userId, $newPassword);
            $log->info('User password updated', [
                'user_id' => $userId,
                'email' => $email
            ]);
            $errors['success'] = 'Password updated successfully';
        } else {
            $errors = $validator->getErrors();
        }
    }
}
?>

<?php require __DIR__.'/includes/head.php';?>

<div class="container">
    <h1 class="my-4">Change password</h1>

    <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['success']; ?>
    </div>
    <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['alert'] ?? ''; ?>
    </div>
    
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">

        <?php $csrf->insertToken(); ?>
        
        <div class="mb-3">
            <label for="email">Email:</label>
            <input id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" disabled>
        </div>

        <div id="alertCurrentPassword" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['currentPassword']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['currentPassword']; ?>
        </div>
        <div class="mb-3">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" class="form-control">
        </div>

        <div id="alertNewPassword" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['newPassword']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['newPassword']; ?>
        </div>
        <div class="mb-3">
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" class="form-control">
        </div>

        <div id="alertNewPassword2" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['newPassword2']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['newPassword2']; ?>
        </div>
        <div class="mb-3">
            <label for="newPassword2">Confirm New Password:</label>
            <input type="password" id="newPassword2" name="newPassword2" class="form-control">
        </div>
        <button type="submit" id="submitButton" class="btn btn-primary d-flex align-items-center" <?php echo isset($errors['success'])||isset($errors['alert']) ? 'disabled' : ''; ?>>
            <span class="material-symbols-outlined">save</span>
            Save changes
        </button>
    </form>
</div>

<script type="module" src="./js/reset-password.js"></script>
<?php require __DIR__.'/includes/foot.php';?>

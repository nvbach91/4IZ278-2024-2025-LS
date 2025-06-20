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

$name = $user['name'];
$email = $user['email'];
$phone = $user['phone'];
$address = $user['address'];

if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on account.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {    
        $validator = new Validator();
        $name = htmlspecialchars(trim($_POST['name']));
        $phone = htmlspecialchars(trim($_POST['phone'])); 
        $address = htmlspecialchars(trim($_POST['address']));

        $validator->validateRequiredField('name', $name);
        $validator->validatePhone('phone', $phone);
        $validator->validateRequiredField('address', $address);

        if(!$validator->hasErrors()) {
            $usersDB->updateUser($userId, $name, $phone, $address);
            $errors['success'] = 'Account updated successfully';
            $log->info('User account updated', [
                'user_id' => $userId,
                'name' => $name,
                'phone' => $phone,
                'address' => $address
            ]);
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['address'] = $address;
        } else {
            $errors = $validator->getErrors();
        }
    }
}
?>

<?php require __DIR__.'/includes/head.php';?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="my-4">Edit Account</h1>
        <a href="<?php echo $urlPrefix ?>/account-history.php" class="btn btn-secondary">
            <span class="material-symbols-outlined align-middle">overview</span>
            Show order history
        </a>
    </div>

    <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['success']; ?>
    </div>
    <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['alert']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['alert']; ?>
    </div>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">

        <?php $csrf->insertToken(); ?>
        
        <div id="alertName" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['name']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['name']; ?>
        </div>
        <div class="mb-3">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? htmlspecialchars($name) : ''?>">
        </div>

        <div class="mb-3">
            <label for="email">Email:</label>
            <input id="email" name="email" class="form-control" value="<?php echo isset($email) ? htmlspecialchars($email) : ''?>" disabled>
        </div>

        <div id="alertPhone" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['name']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['phone']; ?>
        </div>
        <div class="mb-3">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''?>">
        </div>

        <div id="alertAddress" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['name']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['address']; ?>
        </div>
        <div class="mb-3">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" class="form-control" value="<?php echo isset($address) ? htmlspecialchars($address) : ''?>">
        </div>
        <button type="submit" id="submitButton" class="btn btn-primary d-flex align-items-center" <?php echo isset($errors['success']) ? 'disabled' : ''; ?>>
            <span class="material-symbols-outlined">save</span>
            Save changes
        </button>
    </form>
    <?php if (!empty($user['password'])): ?>
        <a href="<?php echo $urlPrefix ?>/account-reset-password.php" class="btn btn-secondary mt-3 <?php echo isset($errors['success'])||isset($errors['alert']) ? 'disabled' : ''; ?>">
            <span class="material-symbols-outlined align-middle">lock</span>
            Change password
        </a>
    <?php endif; ?>
</div>

<script type="module" src="./js/account.js"></script>
<?php require __DIR__.'/includes/foot.php';?>

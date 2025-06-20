<?php require_once __DIR__ . '/prefix.php'; ?>
<?php require_once __DIR__ .'/vendor/autoload.php'; ?>
<?php require __DIR__.'/utils/Validator.php';?>
<?php require_once __DIR__.'/database/UsersDB.php';?>
<?php require __DIR__.'/google-login/credentials.php';?>
<?php include_once __DIR__.'/utils/Email.php';?>
<?php require_once __DIR__ . '/utils/Logger.php'; ?>
<?php
if(!isset($_SESSION)) {   
    session_start();        
}
$csrf = new \ParagonIE\AntiCSRF\AntiCSRF;
$usersDB = new UsersDB();
$emailClient= new Email();
$errors = [];
$log = AppLogger::getLogger();

if (!empty($_POST)) {
    if (!$csrf->validateRequest()) {
        $errors['alert']="Invalid CSRF token.<br> Use <a href=".$_SERVER['PHP_SELF'].">this link</a> to reload page.";
        $log->error('Invalid CSRF token on register.php', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    } else {
        $validator = new Validator();
        
        $name = htmlspecialchars(trim($_POST['name'])); 
        $email= htmlspecialchars(trim($_POST['email']));
        $phone = htmlspecialchars(trim($_POST['phone']));
        $address = htmlspecialchars(trim($_POST['address']));
        $password = trim($_POST['password']);
        $password2 = trim($_POST['password2']);

        $validator->validateRequiredField('name', $name);
        $validator->validateEmail('email', $email);
        $validator->validatePhone('phone', $phone);
        $validator->validateRequiredField('address', $name);
        $validator->validatePassword('password', $password, $password2); 

        if(!$validator->hasErrors()) {
            $existingUser = $usersDB->fetchUserByEmail($email);
            if ($existingUser) {
                $errors['email'] = 'Email already exists';
            } else {
                $userId = $usersDB->addUser($name, $email, $phone, $address, $password, 1);
                $emailClient->sendRegistrationSuccess($userId, $name, $email, $phone, $address);
                $log->info('New user registered', [
                    'user_id' => $userId,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address
                ]);
                $errors['success'] = 'Registration successful. Please check your email for confirmation.';
            }
        } else {
            $errors = $validator->getErrors();
        }
    }
}
?>

<script src="https://accounts.google.com/gsi/client?hl=en" async></script>
<?php require __DIR__.'/includes/head.php';?>
<div class="container">
    <h1 class='my-4'>Register</h1>

    <div class="alert alert-success" role="alert" style="display: <?php echo isset($errors['success']) ? 'block' : 'none'; ?>;">
        <?php echo $errors['success']; ?>
    </div>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        
        <?php $csrf->insertToken(); ?>
        <div id="alertName" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['name']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['name']; ?>
        </div>
        <div class="mb-3">
            <label for="name">*Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? $name : ''?>">
        </div>

        <div id="alertEmail" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['email']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['email']; ?>
        </div>
        <div class="mb-3">
            <label for="email">*Email:</label>
            <input id="email" name="email" class="form-control" value="<?php echo isset($email) ? $email : ''?>">
        </div>

        <div id="alertPhone" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['phone']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['phone']; ?>
        </div>
        <div class="mb-3">
            <label for="phone">Phone:</label>
            <input id="phone" name="phone" class="form-control" value="<?php echo isset($phone) ? $phone : ''?>">
        </div>

        <div id="alertAddress" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['address']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['address']; ?>
        </div>
        <div class="mb-3">
            <label for="address">*Address:</label>
            <input id="address" name="address" class="form-control" value="<?php echo isset($address) ? $address : ''?>">
        </div>

        <div id="alertPassword" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['password']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['password']; ?>
        </div>
        <div class="mb-3">
            <label for="password">*Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="At least 8 characters">
        </div>

        <div id="alertPassword2" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['password2']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['password2']; ?>
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">*Enter password one more time</label>
            <input type="password" id="password2" name="password2" class="form-control">
        </div>
        <button type="submit" id="submitButton" class="btn btn-primary" <?php echo isset($errors['success'])||isset($errors['alert']) ? 'disabled' : ''; ?>>
            Register
        </button>
    </form>

    <!--Google Sign-In Button-->
    <div id="g_id_onload"
        data-client_id="<?php echo $clientID;?>"
        data-context="signin"
        data-ux_mode="redirect"
        data-login_uri="http://localhost/sp/google-login/google-oauth.php"
        data-auto_prompt="false">
    </div>
    <div class="g_id_signin"
        data-locale="en"
        data-type="standard"
        data-shape="rectangular"
        data-theme="outline"
        data-text="signin_with"
        data-size="large"
        data-logo_alignment="left">
    </div>

    Already registered? <a href="<?php echo $urlPrefix;?>/login.php">Login here</a>
</div>

<script type="module" src="./js/register.js"></script>
<?php require __DIR__.'/includes/foot.php';?>

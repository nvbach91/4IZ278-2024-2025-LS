<?php include __DIR__.'/prefix.php'; ?>
<?php require_once __DIR__.'/database/UsersDB.php';?>
<?php include __DIR__.'/google-login/credentials.php';?>
<?php require_once __DIR__ . '/utils/Logger.php'; ?>

<?php
if(!isset($_SESSION)) { 
        session_start(); 
}
$errors = [];
$usersDB = new UsersDB();
$log = AppLogger::getLogger();

if (!empty($_POST)) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $user = $usersDB->fetchUserByEmail($email);
    if ($user) {
        if (!empty($password) && password_verify($password, $user['password'])) {
            if(!isset($_SESSION)) { 
                session_start(); 
            }        
            $_SESSION['user']['id'] = $user['user_id'];
            $_SESSION['user']['name'] = $user['name'];
            $_SESSION['user']['email'] = $user['email'];
            $_SESSION['user']['phone'] = $user['phone'];
            $_SESSION['user']['address'] = $user['address'];
            $_SESSION['user']['privilege'] = $user['privilege'];
            $log->info('User logged in', [
                'user_id' => $user['user_id'],
                'email' => $email
            ]);
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header('Location: ' . $redirect);
                exit();
            }
            header ('Location: '.$urlPrefix.'/index.php');
            exit();
        } else {
            $errors['password'] = 'Invalid password';
        }
    } else {
        $errors['email'] = 'Email not found';
    }
}

?>

<script src="https://accounts.google.com/gsi/client?hl=en" async></script>
<?php require __DIR__.'/includes/head.php';?>
<div class="container">
    <h1 class="my-4">Login</h1>
    <form method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">

        <div id="alertEmail" class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['email']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['email']; ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input name="email" id="email" class="form-control" value="<?php echo isset($email) ? $email : ''?>">
        </div>

        <div class="alert alert-danger" role="alert" style="display: <?php echo isset($errors['password']) ? 'block' : 'none'; ?>;">
            <?php echo $errors['password']; ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" id="submitButton" class="btn btn-primary">Login</button>
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

    Forgot your password? <a href="<?php echo $urlPrefix;?>/password-reset/forgot-password.php">Reset it here</a><br>
    Don't have account? <a href="<?php echo $urlPrefix;?>/register.php">Register here</a>
</div>

<script type="module" src="./js/login.js"></script>
<?php require __DIR__.'/includes/foot.php';?>

<?php include __DIR__ . '/../prefix.php'; ?>
<?php require __DIR__ . '/../vendor/autoload.php' ?>
<?php require __DIR__ . '/credentials.php'; ?>
<?php require_once __DIR__ . '/../database/UsersDB.php'; ?>
<?php include_once __DIR__.'/../utils/Email.php';?>
<?php require_once __DIR__ . '/../utils/Logger.php'; ?>
<?php
$log = AppLogger::getLogger();
if(!isset($_SESSION)) { 
        session_start(); 
}

$usersDB = new UsersDB();
$client = new Google_Client();

if (isset($_POST['credential'])) {
    $idToken = $_POST['credential'];
    $payload = $client->verifyIdToken($idToken);
    if ($payload) {
        $name = $payload['name'];
        $email = $payload['email'];
        $user = $usersDB->fetchUserByEmail($email);
        if ($user) {
            if ($user['password'] == null) {
                $_SESSION['user']['id'] = $user['user_id'];
                $_SESSION['user']['name'] = $user['name'];
                $_SESSION['user']['email'] = $user['email'];    
                $_SESSION['user']['privilege'] = $user['privilege'];
                $_SESSION['user']['phone'] = $user['phone'];
                $_SESSION['user']['address'] = $user['address'];
                $log->info('User logged in with Google', [
                    'user_id' => $user['user_id'],
                    'name' => $name,
                    'email' => $email
                ]);
                header('Location: '.$urlPrefix.'/index.php');
                exit;
            } else {
                $status = 'This email is already registered with as a local account.';
                $status2 = 'Please <a href='.$urlPrefix.'/login.php>log in</a> with your password or use a different email to <a href='.$urlPrefix.'/register.php>register</a>.';
                $log->warning('User attempted to register with an email already used for a local account', [
                    'user_id' => $user['user_id'],
                    'name' => $name,
                    'email' => $email
                ]);
            }
        } else {
            $id = $usersDB->addUserFromGoogle($name, $email, 1);
            $_SESSION['user']['id'] = $id;
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['privilege'] = 1;
            $status = 'Registration successful';
            $status2 = 'You are now logged in. <br> Please <a href="'.$urlPrefix.'/account.php">complete your account details</a>.';
            $log->info('New user registered with Google', [
                'user_id' => $id,
                'name' => $name,
                'email' => $email
            ]);
        }
    } else {
        $status = 'Invalid google ID token';
        $log->warning('Invalid Google ID token', [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    }
}
?>

<?php include __DIR__.'/../includes/head.php';?>

<div class="container">
    <h1 class="my-4"><?php echo $status ?></h1>
    <?php if (isset($status2)) { ?>
        <p><?php echo $status2 ?></p>
    <?php } ?>
</div>

<?php include __DIR__.'/../includes/foot.php';?>
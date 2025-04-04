<?php require_once __DIR__.'/database/UsersDB.php';?>

<?php
$errors = [];
$usersDB = new UsersDB();
$isEnteredName = !empty($_POST);

if (!empty($_POST)) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $user = $usersDB->fetchUserByEmail($email);
    if ($user) {
        if (password_verify($password, $user['password'])) {
            if(!isset($_SESSION)) { 
                session_start(); 
            }        
            $_SESSION['user']['id'] = $user['user_id'];
            $_SESSION['user']['name'] = $user['name'];
            $_SESSION['user']['privilege'] = $user['privilege'];
            header ('Location: ./index.php');
            exit();
        } else {
            $errors['password'] = 'Invalid password';
        }
    } else {
        $errors['email'] = 'Email not found';
    }
}

?>

<?php include __DIR__.'/includes/head.php'; ?>
<div class="container">
    <h2>Login</h2>
    <form method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">
        <?php if(isset($errors['email'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['email']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input name="email" class="form-control" id="email" value="<?php echo isset($email) ? $email : ''?>">
        </div>

        <?php if(isset($errors['password'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['password']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    Don't have account? <a href="<?php echo $prefix;?>/register.php">Register here</a>
</div>

<?php include __DIR__.'/includes/foot.php'; ?>
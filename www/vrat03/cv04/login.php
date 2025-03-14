<?php 

$isSubmitedForm = !empty($_POST);
$errors=[];
$email = isset($_GET['email']) ? htmlspecialchars(trim($_GET['email'])) : '';
if (isset($_GET['success']) && $_GET['success'] == '1' ) {
    $errors['success'] = 'Registration was successful!';
}

function fetchUsers() {
    $users = [];
    $lines = file('./users.db');
    foreach($lines as $line) {
        $fields = explode(';',trim($line));
        $user = [];
        $user['email'] = $fields[1];
        $user['password'] = $fields[2];
        array_push($users, $user);
    }
    return $users;
}

function fetchUser($email) {
    $users = fetchUsers();
    foreach($users as $user) {
        if ($user['email']==$email)
        return $user;
    }
    return null;
}

if ($isSubmitedForm) {
    authenticate($errors);
}

function authenticate(&$errors){
    global $email;
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim(htmlspecialchars(trim($_POST['password'])));
    $user = fetchUser($email);
    if(!$user){
        $errors['email'] = 'User with this email does not exist'; 
    }
    elseif (trim($user['password']) == $password) {
        $errors['success'] = 'Login was successful';
    } else {
        $errors['password'] = 'Invalid password';
    }
}

?>


<?php include __DIR__.'/includes/head.php'; ?>
<form class="form" method='POST' action="<?php echo$_SERVER['PHP_SELF'];?>">
    <h1>Login</h1>
    <?php if(isset($errors['success'])):?>
        <div class="alert alert-success" role="alert">
            <?php echo $errors['success']; ?>
        </div>
    <?php endif; ?>

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
<?php include __DIR__.'/includes/foot.php'; ?>
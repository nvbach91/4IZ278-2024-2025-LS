<?php
require_once __DIR__ . '/../database/UsersDB.php';
include __DIR__ . '/header.php';

$required = array('email', 'password');
$isSubmettedForm = !empty($_POST);
$errors = [];

if ($isSubmettedForm) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));;

    $usersDB = new UsersDB();
    $user = $usersDB->findOneByEmail($email);
    if ($user == null) {
        echo 'User not found';
        exit;
    }
    $isPasswordCorrect = password_verify($password, $user['password']);
    if (!$isPasswordCorrect) {
        echo 'Password is incorrect';
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "This field is required";
        }
    }

    if (empty($errors)) {
        setcookie('name', $user['name'], time() + 3600, "/");
        setcookie('id', $user['User_id'], time() + 3600, "/");
        session_start();
        $_SESSION['username'] = $user['email'];
        $_SESSION['privilege'] = $user['privilege'];
        header('Location: /4IZ278/DU/du06/index.php');
        exit;
    }
}
?>
<main class="container">
    <h1>Login</h1>
    <form class="form-signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <?php if (isset($errors['name'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['name']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Email*</label>
            <input class="form-control" name="email" value="<?php echo isset($name) ? $name : '' ?>">
        </div>
        <div class="form-group">
            <label>Password*</label>
            <input type="password" class="form-control" name="password" value="<?php echo isset($password) ? $password : '' ?>">
            <a href="/4IZ278/DU/du06/includes/registration.php">Dont have an account yet?</a>
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</main>
<?php include __DIR__ . '/footer.php'; ?>
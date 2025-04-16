<?php
require_once __DIR__ . '/../database/UsersDB.php';
include __DIR__ . '/header.php';

$required = array('email', 'password', 'name');
$isSubmettedForm = !empty($_POST);
$errors = [];

if ($isSubmettedForm) {
    $user = [];
    $user['email'] = htmlspecialchars(trim($_POST['email']));
    $user['password'] = htmlspecialchars(trim($_POST['password']));
    $user['privilege'] = 1;
    $user['name'] = htmlspecialchars(trim($_POST['name']));


    if (!preg_match('/^[a-zA-Z0-9_\.-]+@[a-zA-Z0-9_\.-]+\.[a-zA-Z]+$/', $user['email'])) {
        $errors['name'] = 'Enter valid email';
    }
    if (!preg_match('/^.{8,}$/', $user['password'])) {
        $errors['password'] = 'Password must have length atleast 8 characters';
    }
    $usersDB = new UsersDB();
    $foundUser = $usersDB->findOneByEmail($user['email']);
    if ($foundUser != null) {
        $errors['exists'] = 'User with this email already exist';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "This field is required";
        }
    }

    if (empty($errors)) {
        $usersDB->create($user);
        header('Location: /4IZ278/DU/du06/includes/login.php');
        exit();
    }
}
?>
<main class="container">
    <h1>Registration</h1>
    <form class="form-signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <?php if (isset($errors['name'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['name']; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($errors['exists'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['exists']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Name*</label>
            <input class="form-control" name="name" value="<?php echo isset($name) ? $name : '' ?>">
        </div>
        <?php if (isset($errors['email'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['email']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Email*</label>
            <input class="form-control" name="email" value="<?php echo isset($email) ? $email : '' ?>">
        </div>
        <?php if (isset($errors['password'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['password']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Password*</label>
            <input type="password" class="form-control" name="password" value="<?php echo isset($password) ? $password : '' ?>">
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</main>
<?php include __DIR__ . '/footer.php'; ?>
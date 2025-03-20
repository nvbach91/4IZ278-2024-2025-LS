<?php include '../includes/header.php';
require(__DIR__ . "/./registration.php");

$required = array('email', 'password');
$isSubmettedForm = !empty($_POST);
$errors = [];

if ($isSubmettedForm) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (!preg_match('/^[a-zA-Z0-9_\.-]+@[a-zA-Z0-9_\.-]+\.[a-zA-Z]+$/', $email)) {
        $errors['email'] = 'Invalid email format';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = "This field is required";
            }
        }
    }
    function authenticate($email, $password, &$errors)
    {
        $user = fetchUser($email);
        if ($user === null) {
            $errors['notFound'] = 'User not found';
            return false;
        } elseif ($user["password"] !== $password) {
            $errors['incorectPass'] = 'Password is incorrect';
            return false;
        }
        return true;
    }

    authenticate($email, $password, $errors);
}
?>

<main class="container">
    <h1>Login</h1>
    <?php if (empty($errors) && !empty($_POST)) : ?>
        <div class="alert alert-success"> Login was successful </div>
    <?php endif ?>
    <?php if (isset($errors['notFound'])) : ?>
        <div class="alert alert-danger">
            <?php echo $errors['notFound']; ?>
        </div>
    <?php endif; ?>
    <form class="form-signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <?php if (isset($errors['email'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['email']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Email*</label>
            <input class="form-control" name="email" value="<?php echo $_GET['email'] ?? '' ?>">
        </div>
        <?php if (isset($errors['incorectPass'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['incorectPass']; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($errors['password'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['password']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Password*</label>
            <input type="password" class="form-control" name="password" value="<?php echo isset($password) ? $password : '' ?>">
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
    </form>
</main>
<?php include '../includes/footer.php'; ?>
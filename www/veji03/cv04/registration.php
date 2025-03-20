<?php
require './utils/utils.php';

$invalidInputs = [];
$alertMessages = [];
$alertType = 'alert-danger';

$name = $email = $password = $confirm = "";

$submittedForm = !empty($_POST);
if ($submittedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST["password"]));
    $confirm = htmlspecialchars(trim($_POST["confirm"]));

    if (!$name) {
        array_push($alertMessages, 'Please enter your name');
        array_push($invalidInputs, 'name');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($alertMessages, 'Please use a valid email address');
        array_push($invalidInputs, 'email');
    }
    if (!$password) {
        array_push($alertMessages, 'Please enter password');
        array_push($invalidInputs, 'password');
    }
    if ($password !== $confirm) {
        array_push($alertMessages, 'Passwords do not match');
        array_push($invalidInputs, 'confirm');
    }
    
    if (empty($invalidInputs)) {
        if (registerNewUser ($name, $email, $password) === false) {
            array_push($alertMessages, 'This Email is already used');
        } else {
            $alertType = 'alert-success';
            $alertMessages = ['You have successfully signed up!'];
            header("Location: login.php?email=" . urlencode($email));
            exit();
        }
    }
}
?>

<?php include './includes/header.php'; ?>

<div class="container mt-5">
    <h2>Registration form</h2>
    
    <?php if (!empty($alertMessages)): ?>
        <div class="alert <?= $alertType ?>">
            <ul>
                <?php foreach ($alertMessages as $message): ?>
                    <li><?= htmlspecialchars($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="form-signup" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" value="<?php echo isset($name) ? $name : '' ?>">
            <small class="text-muted">Example: Franta Flinta</small>
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input class="form-control" type="email" name="email" value="<?php echo isset($email) ? $email : '' ?>">
            <small class="text-muted">Example: example@mailinator.com</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" value="<?php echo isset($password) ? $password : '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm password</label>
            <input class="form-control" type="password" name="confirm" value="<?php echo isset($confirm) ? $confirm : '' ?>">
        </div>
        <button class="btn btn-primary" type="submit">Register</button>
    </form>

</div>
<?php include './includes/footer.php'; ?>

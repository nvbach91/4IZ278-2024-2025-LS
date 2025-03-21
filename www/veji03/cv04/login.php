<?php
require './utils/utils.php';

$alertMessages = [];
$alertType = 'alert-danger';
$email = '';

if (isset($_GET['email'])) {
    $email = htmlspecialchars($_GET['email']);
    $alertMessages[] = 'Registration successful!';
    $alertType = 'alert-success';
}

$submittedForm = !empty($_POST);
if ($submittedForm) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($email) || empty($password)) {
        $alertMessages[] = 'Fill in all required fields.';
    } 
        
    $authResult = authenticate($email, $password);
    if ($authResult === 'email') {
        $alertMessages[] = 'A user with this email does not exist.';
        $alertType = 'alert-danger';
    } elseif ($authResult === 'password') {
        $alertMessages[] = 'Wrong password';
        $alertType = 'alert-danger';
    } else {
        $alertMessages[] = 'Login successful!';
        $alertType = 'alert-success';
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
            <label class="form-label">E-mail</label>
            <input class="form-control" type="email" name="email" value="<?php echo isset($email) ? $email : '' ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password">
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
    </form>

</div>


<?php include './includes/footer.php'; ?>
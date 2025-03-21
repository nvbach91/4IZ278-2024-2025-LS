<?php
include '../includes/header.php';
require(__DIR__ . "/./registration.php");

$required = array('name', 'lastName', 'email', 'password', 'passwordCheck');
$isSubmettedForm = !empty($_POST);
$errors = [];

if ($isSubmettedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $passwordCheck = htmlspecialchars(trim($_POST['passwordCheck']));


    if (!preg_match('/^[a-zA-Z0-9_\.-]+@[a-zA-Z0-9_\.-]+\.[a-zA-Z]+$/', $email)) {
        $errors['email'] = 'Invalid email format';
    }

    if (!preg_match('/^[a-zA-Z]+$/', $name)) {
        $errors['name'] = 'Enter valid name';
    }
    if (!preg_match('/^[a-zA-Z]+$/', $lastName)) {
        $errors['lastName'] = 'Enter valid last name';
    }
    if (!preg_match('/^.{8,}$/', $password)) {
        $errors['passwordLength'] = 'Password must be atleast 8 characters long';
    }
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{1,}$/', $password)) {
        $errors['passwordChars'] = 'Password must contain atleast one uppercase,lowercase number and special character';
    }
    if ($password != $passwordCheck) {
        $errors['passwordCheck'] = 'Passwords do not match';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "This field is required";
        }
    }
}
?>
<main class="container">
    <h1>Card game tournament Registration form</h1>


    <form class="form-signup" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <?php if (isset($errors['name'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['name']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Name*</label>
            <input class="form-control" name="name" value="<?php echo isset($name) ? $name : '' ?>">
        </div>
        <?php if (isset($errors['lastName'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['lastName']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Last name*</label>
            <input class="form-control" name="lastName" value="<?php echo isset($lastName) ? $lastName : '' ?>">
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
        <?php if (isset($errors['passwordChars'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['passwordChars']; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($errors['passwordLength'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['passwordLength']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Password*</label>
            <input type="password" class="form-control" name="password" value="<?php echo isset($password) ? $password : '' ?>">
        </div>
        <?php if (isset($errors['passwordCheck'])) : ?>
            <div class="alert alert-danger">
                <?php echo $errors['passwordCheck']; ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Password again*</label>
            <input type="password" class="form-control" name="passwordCheck" value="<?php echo isset($passwordCheck) ? $passwordCheck : '' ?>">
        </div>
        <?php if (empty($errors) && $_SERVER["REQUEST_METHOD"] == "POST") : ?>
            <?php $user = ["name" => $name, "lastName" => $lastName, "email" => $email, "password" => $password]; ?>
            <?php if (registerNewUser($user) === null) : ?>
                <div class="alert alert-danger">
                    User with this email already exists.
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    Registration was successful.
                </div>
                <?php mail($email, "Registration", "You registration was successful");
                header('Location: ./login.php?email=' . urlencode($email)); ?>
            <?php endif; ?>
        <?php endif; ?>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</main>
<?php include '../includes/footer.php'; ?>
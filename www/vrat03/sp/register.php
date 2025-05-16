<?php require 'Validator.php';?>
<?php require_once __DIR__.'/database/UsersDB.php';?>
<?php
$usersDB = new UsersDB();
$errors = [];

if (!empty($_POST)) {
    $name = htmlspecialchars(trim($_POST['name'])); 
    $email= htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = htmlspecialchars(trim($_POST['address']));
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);

    $validator = new Validator();

    $validator->validateRequiredField('name', $name);
    $validator->validateEmail('email', $email);
    $validator->validatePhone('phone', $phone);
    $validator->validatePassword('password', $password, $password2); 

    if(!$validator->hasErrors()) {
        $existingUser = $usersDB->fetchUserByEmail($email);
        if ($existingUser) {
            $errors['email'] = 'Email already exists';
        } else {
            $usersDB->addUser($name, $email, $phone, $address, $password, 1);
            header('Location: login.php');
            exit();
        }
    } else {
        $errors = $validator->getErrors();
    }
}
?>

<?php require 'includes/head.php';?>

<div class="container">
    <h2>Register</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if(isset($errors['name'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['name']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="name">*Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? $name : ''?>">
        </div>

        <?php if(isset($errors['email'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['email']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="email">*Email:</label>
            <input id="email" name="email" class="form-control" value="<?php echo isset($email) ? $email : ''?>">
        </div>

        <?php if(isset($errors['phone'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['phone']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo isset($phone) ? $phone : ''?>">
        </div>

        <?php if(isset($errors['address'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['address']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" class="form-control" value="<?php echo isset($address) ? $address : ''?>">
        </div>

        <?php if(isset($errors['password'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['password']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="password">*Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="At least 8 characters">
        </div>

        <?php if(isset($errors['password2'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['password2']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="password2" class="form-label">*Enter password one more time</label>
            <input type="password" name="password2" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    Already registered? <a href="<?php echo $prefix;?>/login.php">Login here</a>
</div>

<?php require 'includes/foot.php';?>

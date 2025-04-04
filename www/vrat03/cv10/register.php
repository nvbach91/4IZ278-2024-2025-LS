<?php require_once __DIR__.'/database/UsersDB.php';?>

<?php
$usersDB = new UsersDB();
$errors = [];

if (!empty($_POST)) {
    $name = htmlspecialchars(trim($_POST['name'])); 
    $email= htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = htmlspecialchars(trim($_POST['address']));
    $password = htmlspecialchars(trim($_POST['password']));
    $password2 = htmlspecialchars(trim($_POST['password2']));

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid Email';
    } elseif (substr($email, -7) !== '@vse.cz') {
        $errors['email'] = 'Email must be from the vse.cz domain';
    }

    if (empty($name)) {
        $name = explode('@', $email)[0];
    }

    if (!empty($phone) && !preg_match('/^(\+\d{1,3} )?([0-9] ?){9}$/', $phone)) {
        $errors['phoneNumber'] = 'Phone number has incorrect format';
    }

    // if (empty($phone)) {
    //     $errors['phone'] = 'Phone is required';
    // } else if (!preg_match('/^(\+\d{1,3} )?([0-9] ?){9}$/', $phone)) {
    //     $errors['phoneNumber'] = 'Phone number has incorrect format';
    // }

    // if (empty($address)) {
    //     $errors['address'] = 'Address is required';
    // }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }
    elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long';
    }
    if (empty($password2)) {
        $errors['password2'] = 'Enter password one more time';
    }

    if ($password != $password2) {
        $errors['password'] = 'Passwords do not match';
    }

    if(empty($errors)) {
        $existingUser = $usersDB->fetchUserByEmail($email);
        if ($existingUser) {
            $errors['email'] = 'Email already exists';
        } else {
            $usersDB->addUser($name, $email, $phone, $address, $passwordHash);
            header('Location: login.php');
            exit();
        }
    }
}

?>

<?php include __DIR__.'/includes/head.php'; ?>
<div class="container">
    <h2>Register</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php if(isset($errors['Name'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['Name']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control">
        </div>

        <?php if(isset($errors['email'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['email']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="email">*Email:</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="@vse.cz">
        </div>

        <?php if(isset($errors['phone'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['phone']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" class="form-control">
        </div>

        <?php if(isset($errors['address'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['address']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" class="form-control">
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

<?php include __DIR__.'/includes/foot.php'; ?>
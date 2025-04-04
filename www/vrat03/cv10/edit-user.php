<?php require_once __DIR__.'/database/UsersDB.php'; ?>
<?php include __DIR__.'/privileges.php'; ?>

<?php

$usersDB = new UsersDB();
$errors = [];

if(isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['id'];
    $user = $usersDB->fetchUserById($userId);
}

if (!empty($_POST)) {
    $name = htmlspecialchars(trim($_POST['name']));
    $address = htmlspecialchars(trim($_POST['address']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    if (empty($name)) {
        $name = explode('@', $email)[0];
    }

    if (!empty($phone) && !preg_match('/^(\+\d{1,3} )?([0-9] ?){9}$/', $phone)) {
        $errors['phone'] = 'Phone number has incorrect format';
    }

    // if (empty($phone)) {
    //     $errors['phone'] = 'Phone is required';
    // } else if (!preg_match('/^(\+\d{1,3} )?([0-9] ?){9}$/', $phone)) {
    //     $errors['phoneNumber'] = 'Phone number has incorrect format';
    // }

    // if (empty($address)) {
    //     $errors['address'] = 'Address is required';
    // }

    if(empty($errors)) {
        $usersDB->updateUser($userId, $name, $address, $phone);
        $user = $usersDB->fetchUserById($userId);
    }
}
?>


<?php include __DIR__.'/includes/head.php';?>
<div class="container">
    <h2>Edit Profile</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control"><br>
        </div>
        
        <?php if(isset($errors['email'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['email']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly class="form-control"><br>
        </div>

        <?php if(isset($errors['address'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['email']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">   
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" class="form-control"><br>
        </div>

        <?php if(isset($errors['phone'])):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['phone']; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" class="form-control"><br>
        </div>
        <button type="submit"  class="btn btn-primary">Update</button>
    </form>
</div>
<?php include __DIR__.'/includes/foot.php'; ?>
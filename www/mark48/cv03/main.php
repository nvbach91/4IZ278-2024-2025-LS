<?php

require "classes/User.php";

session_start();

$errors = [];

if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $avatar = $_POST['avatar'];


    if (empty($name)) {
        array_push($errors, 'Name is required');
    }
    if (empty($email)) {
        array_push($errors, 'Email is required');
    }
    if (empty($phone)) {
        array_push($errors, 'Phone is required');
    }
    if (empty($avatar)) {
        array_push($errors, 'Avatar is required');
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        array_push($errors, 'Email is not valid');
    }
    if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
        array_push($errors, "Invalid phone number");
    }

    if (!filter_var($avatar, FILTER_VALIDATE_URL)) {
        array_push($errors, "Invalid URL");
    }

    if ($errors == []) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
        $avatar = filter_input(INPUT_POST, 'avatar', FILTER_SANITIZE_URL);

        $user = new User($name, $email, $phone, $avatar, $_POST['gender']);

        $_SESSION['user'] = serialize($user);


        header('Location: profile.php');
        exit();
    }
}

?>
<h1> Form </h1>
<?php foreach ($errors as $error) : ?>
    <div class="alert alert-danger" role="alert"> <?php echo $error ?> </div>
<?php endforeach ?>
<?php if (empty($errors) && !empty($_POST)) : ?>
    <div class="alert alert-success" role="alert"> Form was submitted successfully </div>
<?php endif ?>

<div class="form-container">
    <form class="form-signup" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="form-group">
            <label>Name*</label>
            <input class="form-control" name="name" value="<?php echo $_POST['name'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Gender*</label>
            <select class="form-control" name="gender">
                <option value="male" <?= isset($_POST['gender']) && $_POST['gender'] == 'male' ? 'selected="selected"' : '' ?>>Male</option>
                <option value="female" <?= isset($_POST['gender']) && $_POST['gender'] == 'female' ? 'selected="selected"' : '' ?>>Female</option>
            </select>
        </div>
        <div class="form-group">
            <label>Email*</label>
            <input class="form-control" name="email" value="<?php echo $_POST['email'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Phone*</label>
            <input class="form-control" name="phone" value="<?php echo $_POST['phone'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Avatar URL*</label>
            <input class="form-control" name="avatar" value="<?php echo $_POST['avatar'] ?? '' ?>">
        </div>
        <button class="submit-btn" type="submit">Submit</button>
    </form>
</div>
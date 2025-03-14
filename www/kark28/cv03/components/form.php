<?php
$isSubmittedForm = !empty($_POST);
$errors = [];
$success = '';



if ($isSubmittedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $avatar = htmlspecialchars(trim($_POST['avatar']));
    $alertMessage = [];

    $emailMsg = 'Dear ' . $name . ', You have been succesfully registered to the World Tournament!';
    
    if (!$name) {
        $errors['name'] = 'Please enter your name';
    }

    if (!$surname) {
        $errors['surname'] = 'Please enter your surname';
    }

    if (!in_array($gender, ['N', 'F', 'M'])) {
        $errors['gender'] = 'Please select a gender';
    }
 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email';
    }

    if (preg_match('/^(\+\d{3} )?\d{3} ?\d{3} ?\d{3}$/', $phone)) {
        $errors['phone'] = 'Please enter a valid phone number';
    }

    
    if (!empty($avatar) && !filter_var($avatar, FILTER_VALIDATE_URL)) {
        $errors['avatar'] = 'Please use a valid URL for your avatar';
    }


    if (empty($errors)) {
        array_push($alertMessage, 'Registration has been successful!');
        $alertType = 'alert-success';
        if (mail($email, "Tournament Registration Confirmation", $emailMsg) != false) {
            array_push($alertMessage, ' The confirmation has been sent via email.'); }
        }
    else {
        array_push($alertMessage, 'Registration was unsuccessful, more information below!') ;
        $alertType = 'alert-danger';  
    }
   
}
?>

<main style="width:80%; margin:auto" class="container">
        <h1>Tournament registration form</h1>
        <?php if ($isSubmittedForm): ?>
            <div class="alert <?php echo $alertType; ?>"><?php foreach($alertMessage as $msg): echo $msg . "<br>"; endforeach?></div>
            <?php endif ?>

        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

            <div class="mb-3">
                    <label for="name" class="col-form-label">Name*</label>
                    <input id="name" class="form-control" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
                 <?php if (isset($errors['name'])) : ?>
                    <div class="col-auto alert alert-danger"><?php echo $errors['name']; ?></div>
                <?php endif ?>
                    <label for="surname" class="col-form-label">Surname*</label>
                    <input id="surname" class="form-control" name="surname" value="<?php echo isset($surname) ? $surname : ''; ?>">
                <?php if (isset($errors['surname'])) : ?>
                    <div class="col-auto alert alert-danger "><?php echo $errors['surname']; ?></div>
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="N" <?php echo isset($type) && $type == 'N' ? 'selected' : ''; ?>>Neutral</option>
                    <option value="F" <?php echo isset($type) && $type == 'F' ? 'selected' : ''; ?>>Female</option>
                    <option value="M" <?php echo isset($type) && $type == 'M' ? 'selected' : ''; ?>>Male</option>
                </select>
                <?php if (isset($errors['gender'])) : ?>
                    <div class="alert alert-danger"><?php echo $errors['gender']; ?></div>
                <?php endif ?>
            </div>


            <div class="mb-3">
                <label for="email" class="form-label">Email address*</label>
                <input name="email" type="email" class="form-control" id="email" value="<?php echo isset($email) ? $email : ''; ?>">
                <?php if (isset($errors['email'])) : ?>
                    <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone number</label>
                <input name="phone" class="form-control" id="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
                <?php if (isset($errors['phone'])) : ?>
                    <div class="alert alert-danger"><?php echo $errors['phone']; ?></div>
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label>Avatar URL</label>
                <?php if (isset($avatar) && $avatar): ?>
                    <img style="max-width: 20%;" src="<?php echo $avatar; ?>" alt="avatar">
                <?php endif; ?>
                <input class="form-control" name="avatar" value="<?php echo isset($avatar) ? $avatar : ''; ?>">
            </div>
            <?php if (isset($errors['avatar'])) : ?>
                    <div class="alert alert-danger"><?php echo $errors['avatar']; ?></div>
                <?php endif ?>
            <small>* These fields are required</small>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </main>
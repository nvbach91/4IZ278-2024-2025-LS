<?php
require __DIR__ . '/../database/UserDB.php';
$isSubmittedForm = !empty($_POST);
$errors = [];
$success = '';



if ($isSubmittedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $pass = htmlspecialchars($_POST['pass']);
    $confirm = htmlspecialchars($_POST['confirm']);
 
    $alertMessage = [];
    
    if (!$name) {
        $errors['name'] = 'Please enter your name';
    }
 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email';
    }

    if (strlen($pass) < 8) {
        $errors['pass'] = 'Password must be atleast 8 characters long';
    }

    if ($pass != $confirm) {
        $errors['confirm'] = 'Passwords do not match';
    }


    if (empty($errors)) {
        $registerNewUser = registerNewUser($_POST);
        if (!$registerNewUser['success']) {
            $errors['email'] = $registerNewUser['msg'];
            array_push($alertMessage, 'Registration was unsuccessful, more information below!') ;
            $alertType = 'alert-danger';  
        }}

        if (empty($errors)) {
            header('Location: login.php?ref=registration&email=' . $email);
            exit();
        }     
    
   
}
?>

<main style="width:80%; margin:auto" class="container">
        <h1>Register</h1>
        <?php if ($isSubmittedForm): ?>
            <div class="alert <?php echo $alertType; ?>"><?php foreach($alertMessage as $msg): echo $msg . "<br>"; endforeach?></div>
            <?php endif ?>

        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

            <div class="mb-3">
                    <label for="name" class="col-form-label">Name</label>
                    <input id="name" class="form-control" name="name" placeholder="Name Surname" value="<?php echo isset($name) ? $name : ''; ?>">
                 <?php if (isset($errors['name'])) : ?>
                    <div class="col-auto alert alert-danger"><?php echo $errors['name']; ?></div>
                <?php endif ?>
                    
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="email@email.com" value="<?php echo isset($email) ? $email : ''; ?>">
                <?php if (isset($errors['email'])) : ?>
                    <div class="alert alert-danger"><?php echo $errors['email']; ?></div>
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input name="pass" class="form-control" id="pass" type="password" placeholder="Atleast 8 characters" value="<?php echo isset($pass) ? $pass : ''; ?>">
                <?php if (isset($errors['pass'])) : ?>
                    <div class="alert alert-danger"><?php echo $errors['pass']; ?></div>
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label for="confirm" class="form-label">Confirm Password</label>
                <input name="confirm" class="form-control" id="confirm" type="password" value="<?php echo isset($confirm) ? $confirm : ''; ?>">
                <?php if (isset($errors['confirm'])) : ?>
                    <div class="alert alert-danger"><?php echo $errors['confirm']; ?></div>
                <?php endif ?>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <a href="./login.php">Already have an account? Log in here!</a>

    </main>
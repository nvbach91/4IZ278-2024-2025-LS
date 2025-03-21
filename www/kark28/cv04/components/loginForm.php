<?php
require './utils/utils.php';
$isSubmittedForm = !empty($_POST);
$errors = [];
$success = '';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} 

if ($isSubmittedForm) {
    $email = htmlspecialchars(trim($_POST['email']));
    $pass = htmlspecialchars($_POST['pass']);

    $alertMessage = [];
    
    $authentication = authenticate($email, $pass);
    if (!$authentication['success']) {
        $errors['authentication'] = $authentication['msg'];
    } else {
        header('Location: index.php?email=' . $email);
        exit();
 
}
}

?>

<main style="width:80%; margin:auto" class="container">
        <h1>Register</h1>
        <?php if ($isSubmittedForm): ?>
            <div class="alert <?php echo $alertType; ?>"><?php foreach($alertMessage as $msg): echo $msg . "<br>"; endforeach?></div>
            <?php endif ?>
            <?php if (isset($_GET['email']) && $_GET['ref'] === 'registration'): ?>
            <div class="alert alert-success">Your registration was successfull!</div>
        <?php endif; ?>

        <?php if ($isSubmittedForm && !empty($errors)): ?>
            <div class="alert alert-danger">
                <?php echo implode('<br>', array_values($errors)); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

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

            <br>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

    </main>
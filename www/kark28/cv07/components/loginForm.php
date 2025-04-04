<?php
require __DIR__ . '/../database/UserDB.php';
$userDB = new UserDB();
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
    
    $authentication = $userDB->authenticate($email, $pass);
    if (!$authentication['success']) {
        $errors['authentication'] = $authentication['msg'];
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        setcookie("name", $_POST['name'], time() + 3600); 
        header('Location: index.php');
   exit();
 
}
}}

?>

<main style="width:80%; margin:auto" class="container">
        <h1>Login</h1>
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
                <label for="name" class="form-label">name</label>
                <input name="name" class="form-control" id="name">
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

            <br>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <a href="./register.php">Don't have an account? Register here!</a>

    </main>
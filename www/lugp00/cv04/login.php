<?php

require_once 'functions.php';

$email = "";
$message = "";
$messageColor = "red";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['email'])) {
        $email = trim($_GET['email']);
    }
    if (isset($_GET['registered']) && $_GET['registered'] == 1) {
        $message = "Registrace proběhla úspěšně. Můžete se nyní přihlásit.";
        $messageColor = "green";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    $errors = [];
    if(empty($email)) {
        $errors[] = "E-mail je povinný.";
    }
    if(empty($password)) {
        $errors[] = "Heslo je povinné.";
    }
    
    if(empty($errors)) {
        $result = authenticate($email, $password);
        if($result['success']) {
            $message = $result['message'];
            $messageColor = "green";
        } else {
            $message = $result['message'];
            $messageColor = "red";
        }
    } else {
        $message = implode("<br>", $errors);
        $messageColor = "red";
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přihlášení</title>
</head>
<body>
    <h1>Přihlášení</h1>
    
    <?php if (!empty($message)): ?>
        <p style="color: <?php echo $messageColor; ?>;"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <form action="login.php" method="post">
        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>"><br>
        
        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password"><br>
        
        <input type="submit" value="Přihlásit se">
    </form>
    
    <p>Ještě nemáte účet? <a href="registration.php">Registrovat se</a></p>
</body>
</html>

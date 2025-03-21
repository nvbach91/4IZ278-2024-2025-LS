<?php

require_once 'functions.php';

$name = "";
$email = "";
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    
    if(empty($name)) {
        $errorMessages[] = "Jméno je povinné.";
    }
    if(empty($email)) {
        $errorMessages[] = "E-mail je povinný.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Neplatný formát e-mailu.";
    }
    if(empty($password)) {
        $errorMessages[] = "Heslo je povinné.";
    }
    if(empty($confirm_password)) {
        $errorMessages[] = "Potvrzení hesla je povinné.";
    }
    if($password !== $confirm_password) {
        $errorMessages[] = "Hesla se neshodují.";
    }
    
    if(empty($errorMessages)) {
        $result = registerNewUser($name, $email, $password);
        if($result['success']) {
            header("Location: login.php?email=" . urlencode($email) . "&registered=1");
            exit;
        } else {
            $errorMessages[] = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace</title>
</head>
<body>
    <h1>Registrace</h1>
    
    <?php
    if (!empty($errorMessages)) {
        echo '<ul style="color:red;">';
        foreach($errorMessages as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo '</ul>';
    }
    ?>
    
    <form action="registration.php" method="post">
        <label for="name">Jméno:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>"><br>
        
        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>"><br>
        
        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password"><br>
        
        <label for="confirm_password">Potvrdit heslo:</label>
        <input type="password" name="confirm_password" id="confirm_password"><br>
        
        <input type="submit" value="Registrovat">
    </form>
    
    <p>Máte již účet? <a href="login.php">Přihlásit se</a></p>
</body>
</html>

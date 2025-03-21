<?php
require __DIR__ . '/utils/database.php';

$alerts = [];
$alertType = "";
$success = false;
// check url
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : "";

// check if email is not empty
if (!empty($email)) {
    $alerts[] = "Registration successful! Please log in with your credentials.";
    $alertType = "alert-success";
}

// check if post is not empty
if (!empty($_POST)) {
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : "";
    $password = isset($_POST['password']) ? trim($_POST['password']) : "";
    
    $isValid = true;
    
    if (empty($email)) {
        array_push($alerts, "Email is required");
        $isValid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($alerts, "Email format is invalid");
        $isValid = false;
    }
    
    if (empty($password)) {
        array_push($alerts, "Password is required");
        $isValid = false;
    }
    
    if ($isValid) {
        list($success, $message) = authenticate($email, $password);
        
        if ($success) {
            $alertType = "alert-success";
        } else {
            $alertType = "alert-danger";
        }
        
        array_push($alerts, $message);
    } else {
        $alertType = "alert-danger";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        
        <?php if (!empty($alerts)): ?>
            <div class="alert <?php echo $alertType; ?>">
                <?php echo implode('<br>', $alerts); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" name="password">
            </div>
            
            <button class="btn btn-primary" type="submit">Login</button>
        </form>
        
        <div class="mt-3">
            <a href="index.php">Register new account</a>
        </div>
    </div>
</body>
</html>
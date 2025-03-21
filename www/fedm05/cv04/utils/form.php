<?php
require __DIR__ . '/database.php';

if (empty($_POST)) {
    $alerts = [];
    $alertType = "";
    $success = false;
} else {
    $alerts = [];
    $success = true;

    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : "";
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : "";
    $password = isset($_POST['password']) ? trim($_POST['password']) : "";
    $password_confirm = isset($_POST['password-confirm']) ? trim($_POST['password-confirm']) : "";

    if (empty($name)) {
        array_push($alerts, "Name is required");
        $success = false;
    } elseif (strlen($name) < 2) {
        array_push($alerts, "Name is too short");
        $success = false;
    }
    if (empty($email)) {
        array_push($alerts, "Email is required");
        $success = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($alerts, "Email format is invalid");
        $success = false;
    }

    // check if user with email exists
    if (fetchUser($email) !== null) {
        array_push($alerts, "User with this email already exists");
        $success = false;
    }

    // password validation
    if (empty($password)) {
        array_push($alerts, "Password is required");
        $success = false;
    } elseif (strlen($password) < 5) {
        array_push($alerts, "Password must be at least 5 characters");
        $success = false;
    }

    if (empty($password_confirm)) {
        array_push($alerts, "Please confirm your password");
        $success = false;
    } elseif ($password !== $password_confirm) {
        array_push($alerts, "Passwords do not match");
        $success = false;
    }

    $alertType = $success ? "alert-success" : "alert-danger";

    if ($success) {
        // hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (registerNewUser($name, $email, $hashed_password)) {
            $to = $email;
            $subject = "Registration successful";
            $message = "Thanks for registering on our web";
            $headers = "From: fedm05@vse.cz";

            // email ends with @vse.cz
            if (substr_compare($email, '@vse.cz', -7, 7) === 0) {
                mail($to, $subject, $message, $headers);
            }
            array_push($alerts, "Registration succesful");
            $alertType = "alert-success";
            
            // Redirect to login page after successful registration
            header("Location: ./login.php?email=" . urlencode($email));
            exit;
        } else {
            array_push($alerts, "Registration failed");
            $alertType = "alert-danger";
            $success = false;
        }
    }
}
?>

<div class="container">
    <h2>Registration form</h2>
    <form class="form-signup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <?php if (!empty($_POST)): ?>
            <div class="alert <?php echo $alertType; ?>">
                <?php echo implode('<br>', $alerts); ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" name="name" value="<?php echo isset($name) ? $name : ""; ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" name="email" value="<?php echo isset($email) ? $email : ""; ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" class="form-control" name="password-confirm">
        </div>

        <button class="btn btn-primary" type="submit">Submit</button>
        <div class="mt-3">
            <a href="login.php">Login with existing account</a>
        </div>
    </form>
</div>
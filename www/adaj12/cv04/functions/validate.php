<?php
$name = $email = $password = $confirm_password = "";
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$successMessage = "";

require_once 'users.php';

function registerNewUser($name, $email, $password) {
    $users = fetchUsers();
    if (fetchUser($email) !== null) {
        return "Email already registered.";
    }
    $file = fopen(__DIR__ . '/../users.db', 'a');
    fputcsv($file, [$email, $password, $name], ";");
    fclose($file);
    return "Registration successful!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $isValid = false;
    } elseif (!preg_match('/^[a-zA-Z]+ [a-zA-Z]+$/', $_POST["name"])) {
        $nameErr = "Full name is required (e.g., Jakub Adam)";
        $isValid = false;
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $isValid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $isValid = false;
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
        $isValid = false;
    } else {
        $password = htmlspecialchars($_POST["password"]);
    }

    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Confirm Password is required";
        $isValid = false;
    } elseif ($_POST["confirm_password"] !== $_POST["password"]) {
        $confirmPasswordErr = "Passwords do not match";
        $isValid = false;
    } else {
        $confirm_password = htmlspecialchars($_POST["confirm_password"]);
    }

    if ($isValid) {
        $registrationResult = registerNewUser($name, $email, $password);
        if ($registrationResult === "Registration successful!") {
            $successMessage = $registrationResult;
            $to = $email;
            $subject = "Registration Successful";
            $message = "successMessage";
            $headers = "From: adaj12@vse.cz";

            if (mail($to, $subject, $message, $headers)) {
                $successMessage .= " An email has been sent to $email.";
            } else {
                $successMessage .= " However, the email could not be sent.";
            }
            header("Location: login.php?email=" . urlencode($email) . "&registered=1");
            exit();
        } else {
            $emailErr = $registrationResult;
        }
    }
}
?>
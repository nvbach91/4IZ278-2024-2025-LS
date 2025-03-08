<?php require __DIR__ . "/classes/Player.php" ?>
<?php

$sucess;
$errors = [];
if (empty($_POST)) {
    return;
}

$email = htmlspecialchars(trim($_POST["email"]));
$fullName = htmlspecialchars(trim($_POST["fullName"]));
$gender = htmlspecialchars(trim($_POST["gender"]));
$phoneNumber = htmlspecialchars(trim($_POST["phoneNumber"]));
$avatar = htmlspecialchars(trim($_POST["avatar"]));

//validation

if (empty($fullName)) {
    $errors["fullName"] = "Full name is required";
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Email is not valid";
}

if (!preg_match("/^[+]?[(]?\d{3}[)]?[-\s\.]?\d{3}[-\s\.]?\d{3}[-\s\.]?\d{3}$/", $_POST["phoneNumber"])) {
    $errors["phoneNumber"] = "Phone number is not valid";
}


if (!filter_var($_POST["avatar"], FILTER_VALIDATE_URL)) {
    $errors["avatar"] = "Avatar is not valid";
}

$player = new Player(
    $_POST["fullName"],
    $_POST["gender"],
    $_POST["phoneNumber"],
    $_POST["email"],
    $_POST["avatar"]
);

if (empty($errors)) {
    $success = "Welcome " . $player->fullName . ", your account was successfully registered.";
}
?>
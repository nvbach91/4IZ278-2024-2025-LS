<?php
$name = $gender = $email = $phone = $avatar = $deckName = $deckNumber = "";
$nameErr = $genderErr = $emailErr = $phoneErr = $avatarErr = $deckNameErr = $deckNumberErr = "";
$successMessage = "";

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

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
        $isValid = false;
    } else {
        $gender = htmlspecialchars($_POST["gender"]);
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

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone is required";
        $isValid = false;
    } elseif (!preg_match('/^[0-9]*$/', $_POST["phone"])) {
        $phoneErr = "Invalid phone number format";
        $isValid = false;
    } else {
        $phone = htmlspecialchars($_POST["phone"]);
    }

    if (empty($_POST["avatar"])) {
        $avatarErr = "Avatar URL is required";
        $isValid = false;
    } elseif (!filter_var($_POST["avatar"], FILTER_VALIDATE_URL)) {
        $avatarErr = "Invalid URL format";
        $isValid = false;
    } else {
        $avatar = htmlspecialchars($_POST["avatar"]);
    }

    if (empty($_POST["deckName"])) {
        $deckNameErr = "Deck name is required";
        $isValid = false;
    } else {
        $deckName = htmlspecialchars($_POST["deckName"]);
    }

    if (empty($_POST["deckNumber"])) {
        $deckNumberErr = "Number of cards in the deck is required";
        $isValid = false;
    } elseif (!is_numeric($_POST["deckNumber"]) || $_POST["deckNumber"] <= 0) {
        $deckNumberErr = "Invalid number of cards";
        $isValid = false;
    } else {
        $deckNumber = htmlspecialchars($_POST["deckNumber"]);
    }

    if ($isValid) {
        $successMessage = "Registration successful!";
    }
}
?>
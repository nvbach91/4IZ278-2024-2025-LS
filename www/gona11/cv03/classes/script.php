<?php 

$isSubmittedForm = !empty($_POST);

if($isSubmittedForm) {
    $name = htmlspecialchars(trim($_POST['name']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $avatar = htmlspecialchars(trim($_POST['avatar']));
    $deck_name = htmlspecialchars(trim($_POST['deck_name']));
    $card_count = htmlspecialchars(trim($_POST['card_count']));

    $errors = [];
    $success = FALSE;

    //name checks
    if(empty($name)) {
        $errors['name'] = "Enter your name";
    }

    //gender check
    if(empty($gender)) {
        $errors['gender'] = "Select your gender";
    }

    //email checks
    if(empty($email)) {
        $errors['email'] = "Enter your email";
    }

    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] ='Enter a valid email';
    }

    //phone checks
    if(empty($phone)) {
        $errors['phone'] = "Enter your phone number";
    }

    if(!empty($phone) && !preg_match('/^(\+\d{3} ?)?\d{3} ?\d{3} ?\d{3}$/', $phone)) {
        $errors['phone'] = "Incorrect phone format";
    }

    // avatar checks
    if(empty($avatar)) {
        $errors['avatar'] = "Select your avatar";
    }

    //deck name checks
    if(empty($deck_name)) {
        $errors['deck_name'] = "Enter your deck name";
    }

    //card count checks
    if(empty($card_count)) {
        $errors['card_count'] = "Enter number of cards in your deck";
    }

    if(!empty($card_count) && ctype_digit($card_count)) {
        if($card_count < 12) {
            $errors['card_count'] = "Number of cards in deck is too low";
        } elseif ($card_count > 80) {
            $errors['card_count'] = "Number of cards in deck is too high";
        }
    } elseif (!empty($card_count) && !ctype_digit($card_count)) {
        $errors['card_count'] = "Number of cards should consist of numbers only";
    }

    if(empty($errors)) {
        $errors['success'] = "Registration successful!";
    }
}

?>
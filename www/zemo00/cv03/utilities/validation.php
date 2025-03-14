<?php

$errors = [];

$isSubmittedForm = !empty($_POST);
if($isSubmittedForm){
    
    $data = [
        'username' => null,
        'gender' => null,
        'email' => null,
        'phone' => null,
        'avatar' => null,
        'deck' => null,
        'amount' => null
    ];

    foreach(array_keys($data) as $datum) {
        if(empty($_POST[$datum])) {
            array_push($errors, ucfirst($datum) . " is missing.");
        } else {
            $data[$datum] = htmlspecialchars($_POST[$datum]);
        }
    }

    if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format.");
    }
    
    $phonePattern = "/^(\+\d{1,3})?\s?\d{3}\s?\d{3}\s?\d{3}$/";
    if($data['phone'] != null && !preg_match($phonePattern, $data['phone'])){
        array_push($errors, "Invalid phone number format.");
    }

    if(!filter_var($data['avatar'], FILTER_VALIDATE_URL) && $data['avatar'] != null){
        array_push($errors, "Invalid avatar URL.");
    }

    if(!(filter_var($data['amount'], FILTER_VALIDATE_INT) && $data['amount'] > 0) && $data['amount'] != null){
        array_push($errors, "The amount of cards must be a positive integer.");
    }

    if(empty($errors)){
        $successMessage = "You've successfully registered!";
    }


}

?>
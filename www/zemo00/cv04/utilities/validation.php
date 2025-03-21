<?php

require __DIR__ . "/user_management.php";


$errors = [];

$isSubmittedForm = !empty($_POST);
if($isSubmittedForm){
    
    $data = [
        'username' => null,
        'email' => null,
        'password' => null,
        'password2' => null
    ];

    foreach(array_keys($data) as $datum) {
        if(empty($_POST[$datum])) {
            array_push($errors, ucfirst($datum) . " is missing.");
        } else {
            $data[$datum] = htmlspecialchars($_POST[$datum]);
        }
    }

    if($data['email'] != null && (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
        array_push($errors, "Invalid email format.");
    }

    if($data['password'] != $data['password2']){
        array_push($errors, "The two passwords aren't the same.");
    }

    if($data['password'] != null && strlen($data['password']) < 8){
        array_push($errors, "Your password isn't strong enough.");
    }

    if(empty($errors)){
        if(!registerNewUser($data)) {
            array_push($errors, "A user with this email already exists.");
        } else{
            mail(
                $email,
                "Registration",
                "Hello!" . PHP_EOL . "You've successfully registered!",
                "From: zemo00@vse.cz"
            );


            session_start();
            $_SESSION['message'] = "registered";

            $email = urlencode($data['email']);

            header("Location: login.php?email=$email");
            exit();
        }
    }


}

?>
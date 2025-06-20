<?php

function validatePassword(string $password, string $confirmPassword): array {
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = 'Heslo musí mít alespoň 8 znaků.';
    }

    if (!preg_match('/[A-Za-z]/', $password)) {
        $errors[] = 'Heslo musí obsahovat alespoň jedno písmeno.';
    }

    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Heslo musí obsahovat alespoň jedno číslo.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Hesla se neshodují.';
    }

    return $errors;
}

function validateEmail(string $email): array {
    return filter_var($email, FILTER_VALIDATE_EMAIL)
        ? []
        : ["Neplatný formát e-mailu."];
}
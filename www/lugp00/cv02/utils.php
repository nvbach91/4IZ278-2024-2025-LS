<?php

function calculateAge($birthDate) {
    $birthDateObj = new DateTime($birthDate);
    $today = new DateTime();
    $age = $today->diff($birthDateObj)->y;
    return $age;
}
?>

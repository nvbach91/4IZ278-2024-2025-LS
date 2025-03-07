<?php
function calculateAge($birthDate) {
    $birthDateObj = new DateTime($birthDate);
    $today = new DateTime();
    return $today->diff($birthDateObj)->y;
}

function getAddress($person) {
    return "{$person->street} {$person->numberBuilding}{$person->numberOrientation}, {$person->city}";
}

function getFullName($person) {
    return "{$person->nameFirst} {$person->nameLast}";
}

function getAge($person) {
    return calculateAge($person->birthDate);
}
?>
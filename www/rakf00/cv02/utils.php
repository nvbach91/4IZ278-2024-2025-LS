<?php

function getAge(DateTime $birthdate):int
{
    $currentDate = new DateTime();
    return $currentDate->diff($birthdate)->y;
}

?>

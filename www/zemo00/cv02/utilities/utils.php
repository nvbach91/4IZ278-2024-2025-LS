<?php
function getAge($date) {
    $years = date_diff(date_create($date), date_create(date('y-m-d'))) -> y;
    return $years . " years old";
}
?>
<?php

if(!isset($_SESSION)) { 
        session_start(); 
}

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit();
}

function hasPrivilege($requiredPrivilege) {
    if (isset($_SESSION['user']['privilege']) && $_SESSION['user']['privilege'] < $requiredPrivilege){
        header('Location: ./login.php');
    exit();    
    }
}

?>
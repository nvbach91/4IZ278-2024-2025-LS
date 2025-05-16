<?php include_once 'database/UsersDB.php'; ?>
<?php

if(!isset($_SESSION)) { 
        session_start(); 
}

if (!isset($_SESSION['user'])) {
    header('Location: ./login.php');
    exit();
}

function hasPrivilege($requiredPrivilege) {
    $usersDB = new UsersDB();
    $privilege=$usersDB->fetchUserPrivilege($_SESSION['user']['id']);
    if (isset($_SESSION['user']['privilege']) && $privilege < $requiredPrivilege){
        header('Location: ./login.php');
    exit();    
    }
}

?>
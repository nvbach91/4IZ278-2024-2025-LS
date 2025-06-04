<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/UserDB.php";

$userDB = new UserDB();
$user = $userDB->fetchById($_SESSION['user_id']);


require __DIR__ . "/../views/pages/profile_page.php";

?>
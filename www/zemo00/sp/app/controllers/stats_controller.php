<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/GameDB.php";

$gameDB = new GameDB();

$stats = $gameDB->fetchStats($_SESSION['user_id']);

require __DIR__ . "/../views/pages/stats_page.php";

?>
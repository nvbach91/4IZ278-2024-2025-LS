<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/LanguageDB.php";

$languageDB = new LanguageDB();
$languages = $languageDB->fetchAll();

require __DIR__ . "/../views/pages/game_setup_language_page.php";

?>
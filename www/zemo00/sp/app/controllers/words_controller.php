<?php

require_once __DIR__ . "/../models/WordDB.php";

$sort = $_GET['sort'] ?? 'word_id';
$direction = $_GET['direction'] ?? 'asc';

$wordDB = new WordDB();

$words = $wordDB->fetchWords($sort, $direction);


$isManager = in_array($_SESSION['privilege'], [2, 3]);
$editUrl = '';
if ($isManager) {
    $editUrl = BASE_URL;
    if ($_SESSION['privilege'] == 3) {
        $editUrl .= "/admin";
    }
    $editUrl .= "/edit_word";
}

require __DIR__ . "/../views/pages/words_page.php";

?>
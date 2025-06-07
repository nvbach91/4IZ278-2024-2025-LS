<?php

require_once __DIR__ . '/../models/WordDB.php';

$wordDB = new WordDB();

if (!isset($_GET['id'])) {
    http_response_code(404);
    $url = BASE_URL . "/error_404";
    header("Location: $url");
    exit;
}

require_once __DIR__ . '/../models/WordConceptDB.php';
$wordConceptDB = new WordConceptDB();

$word = $wordDB->fetchWord($_GET['id']);

$concepts = $wordConceptDB->fetchConcepts($_GET['id']);

require __DIR__ . "/../views/pages/word_page.php";

?>
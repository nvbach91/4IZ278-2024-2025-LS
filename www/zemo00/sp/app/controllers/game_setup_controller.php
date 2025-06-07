<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/CollectionDB.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $lang_from = $_POST['lang_from'];
    $lang_to = $_POST['lang_to'];

    if ($lang_from === $lang_to) {
        $url = BASE_URL . "/game_setup_language?error=same-language";
        header("Location: $url");
        exit;
    }

    $collectionDB = new CollectionDB();
    $collections = $collectionDB->fetchFilteredCollections($_SESSION['user_id'], $lang_from);

    //same for categories

    require __DIR__ . "/../views/pages/game_setup_page.php";

} else {
    http_response_code(404);
    $url = BASE_URL . "/error_404";
    header("Location: $url");
    exit;
}


?>
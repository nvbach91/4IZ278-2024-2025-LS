<?php

require_once __DIR__ . "/../utils/authenticate_user.php";


if (!isset($_GET['collection_id'])) {
    http_response_code(404);
    $url = BASE_URL . "/error_404";
    header("Location: $url");
    exit;
}

require_once __DIR__ . "/../models/CollectionDB.php";
require_once __DIR__ . "/../models/CollectionWordDB.php";

$collectionDB = new CollectionDB();
$collectionWordDB = new CollectionWordDB();

if (empty($collectionDB->fetchWhere(['user_id' => $_SESSION['user_id'], 'collection_id' => $_GET['collection_id']]))) {
    http_response_code(401);
    $url = BASE_URL . "/error_401";
    header("Location: $url");
    exit;
}

$collection = $collectionDB->fetchById($_GET['collection_id']);

$words = $collectionWordDB->fetchWords($collection['collection_id']);

require __DIR__ . "/../views/pages/collection_page.php";

?>
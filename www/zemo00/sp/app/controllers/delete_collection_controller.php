<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/CollectionDB.php";

$collectionDB = new CollectionDB();

$collectionId = $_GET['collectionId'] ?? null;

if (!$collectionId || empty($collectionDB->fetchWhere([
    'user_id' => $_SESSION['user_id'],
    'collection_id' => $collectionId
]))) {
    http_response_code(401);
    header("Location: " . BASE_URL . "/error_401");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['yes'])) {
        $collectionDB->delete($collectionId);
    }

    header("Location: " . BASE_URL . "/collections");
    exit;
}

require __DIR__ . "/../views/pages/delete_collection_page.php";
?>
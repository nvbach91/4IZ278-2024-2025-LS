<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/CollectionDB.php";

$collectionDB = new CollectionDB();
$collections = $collectionDB->fetchCollections($_SESSION['user_id']);

require __DIR__ . "/../views/pages/collections.php";

?>
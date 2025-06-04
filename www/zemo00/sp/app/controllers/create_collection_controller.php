<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/CollectionDB.php";
require_once __DIR__ . "/../models/LanguageDB.php";
require_once __DIR__ . "/../models/WordDB.php";
require_once __DIR__ . "/../models/CollectionWordDB.php";

$collectionDB = new CollectionDB();
$languageDB = new LanguageDB();
$wordDB = new WordDB();

$languages = $languageDB->fetchAll();
$words = $wordDB->fetchWords();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $name = $_POST['name'] ?? null;
    $icon = $_POST['icon'] ?? null;
    $user_id = $_SESSION['user_id'];
    $wordIds = $_POST['word_ids'] ?? [];

    require __DIR__ . "/../utils/validation.php";

    if (!fieldsNotEmpty([$name])) {
        $errors[] = "The name field is required.";
    }

    if (empty($errors)) {
        try {
            $collectionDB->insert([
                'name' => $name,
                'icon' => $icon,
                'user_id' => $user_id
            ]);

            $collectionId = $collectionDB->fetchSorted('collection_id', 'desc')[0]['collection_id'];

            $collectionWordDB = new CollectionWordDB();
            foreach ($wordIds as $wordId) {
                $collectionWordDB->insert([
                    'collection_id' => $collectionId,
                    'word_id' => $wordId
                ]);
            }
        } catch (Exception $e) {
            $errors[] = "Failed to add the collection";
        }

    }


}

require __DIR__ . "/../views/pages/create_collection.php";

?>
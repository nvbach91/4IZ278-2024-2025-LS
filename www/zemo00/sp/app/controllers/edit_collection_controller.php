<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/CollectionDB.php";
require_once __DIR__ . "/../models/LanguageDB.php";
require_once __DIR__ . "/../models/WordDB.php";
require_once __DIR__ . "/../models/CollectionWordDB.php";

$collectionDB = new CollectionDB();
$languageDB = new LanguageDB();
$wordDB = new WordDB();
$collectionWordDB = new CollectionWordDB();

if (empty($collectionDB->fetchWhere(['user_id' => $_SESSION['user_id'], 'collection_id' => $_GET['collection_id']]))) {
    http_response_code(401);
    $url = BASE_URL . "/error_401";
    header("Location: $url");
    exit;
}

$collectionId = $_GET['collection_id'];

if (!$collectionId) {
    http_response_code(404);
    $url = BASE_URL . "/error_404";
    header("Location: $url");
    exit;
}

$collection = $collectionDB->fetchById($collectionId);

$currentWords = $collectionWordDB->fetchWords($collectionId);
$currentWordIds = [];
foreach ($currentWords as $word) {
    $currentWordIds[] = $word['word_id'];
}
$langCode = $currentWords[0]['lang_code'];

$words = $wordDB->fetchWhere(['lang_code' => $langCode]);

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

        $collectionDB->update($collectionId, [
            'name' => $name,
            'icon' => $icon
        ]);

        $collectionWordDB->deleteWhere(['collection_id' => $collectionId]);

        foreach ($wordIds as $wordId) {
            $collectionWordDB->insert([
                'collection_id' => $collectionId,
                'word_id' => $wordId
            ]);
        }

        $collection = $collectionDB->fetchById($collectionId);

    }

}


require __DIR__ . "/../views/pages/edit_collection_page.php";

?>
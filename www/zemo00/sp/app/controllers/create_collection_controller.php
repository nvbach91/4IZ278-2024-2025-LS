<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/CollectionDB.php";
require_once __DIR__ . "/../models/LanguageDB.php";
require_once __DIR__ . "/../models/WordDB.php";
require_once __DIR__ . "/../models/CollectionWordDB.php";

//$collectionDB = new CollectionDB();
$languageDB = new LanguageDB();
$wordDB = new WordDB();

$sort = $_GET['sort'] ?? 'word_id';
$direction = $_GET['direction'] ?? 'asc';

$languages = $languageDB->fetchAll();

$errors = [];
$langError = '';


$lang = null;
if (isset($_GET['lang']) && $_GET['lang'] !== '') {
    $valid = false;
    foreach ($languages as $language) {
        if ($language['code'] === $_GET['lang']) {
            $valid = true;
            $lang = $_GET['lang'];
            break;
        }
    }
    if (!$valid) {
        $langError = "Invalid language";
    }
}

if ($lang !== null) {
    // === Pagination ===
    $limit = 6;

    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $limit;
    $totalWords = $wordDB->fetchCountByLang($lang);
    $totalPages = ceil($totalWords / $limit);

    // === Fetch words ===
    $words = $wordDB->fetchWords($sort, $direction, $limit, $offset, $lang);

}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $name = trim($_POST['name'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    $wordIds = $_POST['word_ids'] ?? [];
    $user_id = $_SESSION['user_id'] ?? null;

    if ($name === '') {
        $errors[] = "Collection name is required.";
    }

    if (count($wordIds) < 5) {
        $errors[] = "Please select at least 5 words for the collection.";
    }

    if (empty($errors)) {
        try {
            $collectionDB = new CollectionDB();
            $collectionWordDB = new CollectionWordDB();

            $collectionDB->insert([
                'name' => $name,
                'icon' => $icon,
                'user_id' => $user_id
            ]);

            $collectionId = $collectionDB->fetchSorted('collection_id', 'desc')[0]['collection_id'];

            foreach ($wordIds as $wordId) {
                $collectionWordDB->insert([
                    'collection_id' => $collectionId,
                    'word_id' => (int)$wordId
                ]);
            }

            echo "<script>sessionStorage.clear();</script>";

            header("Location: " . BASE_URL . "/collections");
            exit;

        } catch (Exception $e) {
            $errors[] = "Failed to create collection: " . $e->getMessage();
        }
    }

}

require __DIR__ . "/../views/pages/create_collection.php";

?>
<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/CollectionDB.php";
require_once __DIR__ . "/../models/CollectionWordDB.php";
require_once __DIR__ . "/../models/WordConceptDB.php";
require_once __DIR__ . "/../models/WordDB.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $amount = (int) ($_POST['amount'] ?? 0);
    $collectionIds = $_POST['collection_ids'] ?? [];
    $langFrom = $_POST['lang_from'];
    $langTo = $_POST['lang_to'];

    if (empty($collectionIds)) {
        $url = BASE_URL . "/game_setup?error=no-collection";
        header("Location: $url");
        exit;
    }


    $collectionDB = new CollectionDB();
    $totalWords = $collectionDB->totalWords($collectionIds);

    if ($amount > $totalWords) {
        $url = BASE_URL . "/game_setup?error=not-enough-words";
        header("Location: $url");
        exit;
    }
    $collectionWordDB = new CollectionWordDB();
    $wordIds = $collectionWordDB->fetchRandomWordIds($collectionIds, $amount);
    $gameWords = [];
    $wordConceptDB = new WordConceptDB();
    $wordDB = new WordDB();
    foreach ($wordIds as $id) {
            $word = $wordDB->fetchById($id);

        $correctId = $wordConceptDB->fetchTranslation($id, $langTo);
        if ($correctId === null) {
            continue;
        }
        $correctWord = $wordDB->fetchById($correctId);

        $incorrectIds = $wordConceptDB->fetchIncorrectTranslations($id, $langTo);
        $incorrectWords = [];

        foreach ($incorrectIds as $incId) {
            $incWord = $wordDB->fetchById($incId);
            $incorrectWords[] = [
                'id' => $incId,
                'word' => $incWord['word']
            ];
        }
        $gameWords[] = [
            'id' => $id,
            'word' => $word['word'],
            'correct' => [
                'id' => $correctId,
                'word' => $correctWord['word']
            ],
            'incorrect' => $incorrectWords
        ];
    }
    


    require __DIR__ . "/../views/pages/game_page.php";

} else {
    http_response_code(404);
    $url = BASE_URL . "/error_404";
    header("Location: $url");
    exit;
}


?>
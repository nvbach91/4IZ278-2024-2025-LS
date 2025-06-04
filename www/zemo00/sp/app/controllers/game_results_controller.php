<?php

require_once __DIR__ . "/../utils/authenticate_user.php";
require_once __DIR__ . "/../models/GameDB.php";
require_once __DIR__ . "/../models/GameWordDB.php";


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $results = json_decode($_POST['results'] ?? '[]', true);

    $gameDB = new GameDB();
    $gameWordDB = new GameWordDB();

    $gameDB->insert([
        'user_id' => $_SESSION['user_id']
    ]);

    $gameId = $gameDB->lastInsertId();

    $total = count($results);
    $correct = 0;

    foreach ($results as $entry) {
        $wordId = (int) $entry['word_id'];
        $isCorrect = (int) $entry['correct'];

        if ($isCorrect) {
            $correct++;
        }

        $gameWordDB->insert([
            'game_id' => $gameId,
            'word_id' => $wordId,
            'correct' => $isCorrect
        ]);
    }

    $incorrect = $total - $correct;
    $rate = $total > 0 ? round(($correct / $total) * 100) : 0;

    require __DIR__ . "/../views/pages/game_results_page.php";

} else {
    http_response_code(404);
    $url = BASE_URL . "/error_404";
    header("Location: $url");
    exit;
}

?>
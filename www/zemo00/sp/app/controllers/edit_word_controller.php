<?php

require_once __DIR__ . '/../models/WordDB.php';
require_once __DIR__ . '/../models/ConceptDB.php';
require_once __DIR__ . '/../models/WordConceptDB.php';
require_once __DIR__ . '/../models/LanguageDB.php';

$wordDB = new WordDB();
$conceptDB = new ConceptDB();
$wordConceptDB = new WordConceptDB();

$languageDB = new LanguageDB();
$languages = $languageDB->fetchAll();

if (!isset($_GET['id'])) {
    http_response_code(404);
    $url = BASE_URL . "/error_404";
    header("Location: $url");
    exit;
}

$word = $wordDB->fetchWord($_GET['id']);
$assignedConcepts = $wordConceptDB->fetchConcepts($_GET['id']);
$errors = [];
$successMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $wordInput = trim($_POST['word'] ?? '');
    $wordId = $_POST['word_id'];
    $lang = trim($_POST['lang_code'] ?? '');
    $concepts = $_POST['concepts'] ?? [];
    $existingConcepts = $_POST['existing_concepts'] ?? [];
    $timestamp = $_POST['last_updated'] ?? '';

    $currentTimestamp = $wordDB->fetchWhere(['word_id' => $wordId], ['last_updated'])[0]['last_updated'];

    if ($timestamp === $currentTimestamp) {
        $wordDB->update($wordId, [
            'word' => $wordInput,
            'lang_code' => $lang
        ]);
        $wordConceptDB->deleteWhere(['word_id' => $wordId]);
        
        foreach ($existingConcepts as $conceptId) {
            if ($conceptId !== '') {
                $wordConceptDB->insert([
                    'word_id' => $wordId,
                    'concept_id' => $conceptId
                ]);
            }
        }

        foreach ($concepts as $index => $name) {
            $name = trim($name);
            $description = trim($_POST['descriptions'][$index] ?? '');

            if ($name === '') {
                continue;
            }

            $conceptDB->insert([
                'name' => $name,
                'description' => $description
            ]);

            $newConceptId = $conceptDB->lastInsertId();

            $wordConceptDB->insert([
                'word_id' => $wordId,
                'concept_id' => $newConceptId
            ]);

        }
        $successMessages[] = "Word updated successfully.";
        $word = $wordDB->fetchWord($_GET['id']);

    } else {
        $errors[] = "This word was updated in the meantime.";
    }

}

require __DIR__ . "/../views/pages/edit_word_page.php";

?>
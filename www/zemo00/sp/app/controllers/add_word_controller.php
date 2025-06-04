<?php

require_once __DIR__ . '/../models/LanguageDB.php';
require_once __DIR__ . '/../models/ConceptDB.php';

$languageDB = new LanguageDB();
$languages = $languageDB->fetchAll();

$conceptDB = new ConceptDB();

$errors = [];
$successMessages = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    require __DIR__ . "/../utils/validation.php";

    $word = trim($_POST['word'] ?? '');
    $lang_code = trim($_POST['lang_code'] ?? '');
    $concepts = $_POST['concepts'] ?? [];
    $descriptions = $_POST['descriptions'] ?? [];

    if (!fieldsNotEmpty([$word, $lang_code]) || empty($concepts)) {
        $errors[] = "All word fields must be filled and at least one concept is required";
    }

    if (empty($errors)) {
        require_once __DIR__ . '/../models/WordDB.php';

        $insertSuccessful = null;
        $wordDB = new WordDB();
        try {
            $insertSuccessful = $wordDB->insert([
                'word' => $word,
                'lang_code' => $lang_code
            ]);
        } catch (Exception $e) {
            $insertSuccessful = false;
        }
        
        if ($insertSuccessful) {

            $insertedWord = $wordDB->fetchSorted('last_updated', 'desc')[0];
            $word_id = $insertedWord['word_id'];

            require_once __DIR__ . '/../models/WordConceptDB.php';
            $wordConceptDB = new WordConceptDB();
        
            $existingConcepts = $_POST['existing_concepts'] ?? [];

            for ($i = 0; $i < count($concepts); $i++) {
                $conceptName = trim($concepts[$i]);
                $desc = trim($descriptions[$i] ?? '');
                $existingId = $existingConcepts[$i] ?? '';

                if ($existingId) {

                    $concept_id = (int)$existingId;

                } elseif ($conceptName) {

                    try {
                        $conceptDB->insert([
                            'name' => $conceptName,
                            'description' => $desc
                        ]);
                        $concept = $conceptDB->fetchSorted('concept_id', 'desc')[0];
                        $concept_id = $concept['concept_id'];
                        $successMessages[] = "The concept $conceptName has been added.";

                    } catch (Exception $e) {
                        $errors[] = "Concept '$conceptName' already exists or failed.";
                        continue;
                    }
                } else {
                    continue;
                }

                try {
                    $wordConceptDB->insert([
                        'word_id' => $word_id,
                        'concept_id' => $concept_id
                    ]);
                } catch (Exception $e) {
                    $errors[] = "Failed to bind concept ID $concept_id to word.";
                }



/*

                if (!$conceptName) continue;

                $conceptInsertSuccessful = false;
                try {
                    $conceptDB->insert([
                        'name' => $conceptName,
                        'description' => $desc
                    ]);
                    $conceptInsertSuccessful = true;
                    $successMessages[] = "The word has been added.";
                } catch (Exception $e) {
                    $errors[] = "Failed to add concept $conceptName.";
                }

                if ($conceptInsertSuccessful) {

                    $concept = $conceptDB->fetchSorted('concept_id', 'desc')[0];
                    $concept_id = $concept['concept_id'];
                    $successMessages[] = "The concept $conceptName has been added.";

                    try {
                        $wordConceptDB->insert([
                            'word_id' => $insertedWord['word_id'],
                            'concept_id' => $concept_id
                        ]);
                        $successMessages[] = "The concept $conceptName has been bound.";
                    } catch (Exception $e) {
                        $errors[] = "Failed to bind the concept ($conceptName) to the word.";
                    }
                }
                    */
            }

        } else {
            $errors[] = "Failed to add the word.";
        }

    }

}


require __DIR__ . '/../views/pages/add_word_page.php';

?>
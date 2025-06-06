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

    $existingConcepts = $_POST['existing_concepts'] ?? [];
    $concepts = $_POST['concepts'] ?? [];

    $descriptions = $_POST['descriptions'] ?? [];

    $hasAnyConcept = false;

    foreach ($existingConcepts as $id) {
        if (trim($id) !== '') {
            $hasAnyConcept = true;
            break;
        }
    }
    foreach ($concepts as $name) {
        if (trim($name) !== '') {
            $hasAnyConcept = true;
            break;
        }
    }

    if (!fieldsNotEmpty([$word, $lang_code]) || !$hasAnyConcept) {
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
            $successMessages[] = "The word has been added.";

        } catch (Exception $e) {
            $insertSuccessful = false;
        }
        
        if ($insertSuccessful) {

            $insertedWord = $wordDB->fetchSorted('last_updated', 'desc')[0];
            $word_id = $insertedWord['word_id'];

            require_once __DIR__ . '/../models/WordConceptDB.php';
            $wordConceptDB = new WordConceptDB();
        
            foreach ($existingConcepts as $id) {
                $id = trim($id);
                if ($id === '') continue;

                try {
                    $wordConceptDB->insert([
                        'word_id' => $word_id,
                        'concept_id' => (int)$id
                    ]);

                } catch (Exception $e) {
                    $errors[] = "Failed to bind concept ID $id to word.";
                }
            }

            for ($i = 0; $i < count($concepts); $i++) {
                $conceptName = trim($concepts[$i]);
                $desc = trim($descriptions[$i] ?? '');

                if ($conceptName === '') continue;

                try {
                    $conceptDB->insert([
                        'name' => $conceptName,
                        'description' => $desc
                    ]);
                    $concept = $conceptDB->fetchSorted('concept_id', 'desc')[0];
                    $concept_id = $concept['concept_id'];

                    try {
                        $wordConceptDB->insert([
                            'word_id' => $word_id,
                            'concept_id' => $concept_id
                        ]);
                    } catch (Exception $e) {
                        $errors[] = "Failed to bind concept ID $concept_id to word.";
                    }

                } catch (Exception $e) {
                    $errors[] = "Concept '$conceptName' already exists or failed.";
                }
            }

        } else {
            $errors[] = "Failed to add the word.";
        }

    }

}


require __DIR__ . '/../views/pages/add_word_page.php';

?>
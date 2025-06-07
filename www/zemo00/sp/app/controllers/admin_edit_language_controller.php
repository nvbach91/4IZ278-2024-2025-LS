<?php

require __DIR__ . "/../utils/authenticate_admin.php";
require_once __DIR__ . "/../models/LanguageDB.php";

$code = $_GET['code'] ?? '';

$languageDB = new LanguageDB();
$language = $languageDB->fetchById($code);

$errors = [];
$successMessage = null;

if (!$language) {
    http_response_code(404);
    include __DIR__ . "/../../app/views/errors/404.php";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $newCode = $_POST['code'] ?? '';
    $name = $_POST['name'] ?? '';
    $icon = $_POST['icon'] ?? '';
    $submittedTimestamp = $_POST['last_updated'] ?? '';

    if ($newCode === '' || $name === '') {
        $errors[] = "Name and Code are required fields.";
    } else {
        $current = $languageDB->fetchWhere(['code' => $code], ['last_updated'])[0] ?? null;

        if ($current && $submittedTimestamp === $current['last_updated']) {
            try {
                $languageDB->update($code, [
                    'code' => $newCode,
                    'name' => $name,
                    'icon' => $icon
                ]);

                $successMessage = "The language has been successfully updated.";
                $language = $languageDB->fetchById($newCode);

            } catch (Exception $e) {
                $errors[] = "An unexpected error occurred while updating the language.";
            }

        } else {
            $errors[] = "This language was updated by someone else in the meantime. Please reload the page.";
            $language = $languageDB->fetchById($code);
        }
    }
}

require __DIR__ . "/../views/partials/head.php";
require __DIR__ . "/../views/pages/admin_edit_language_page.php";
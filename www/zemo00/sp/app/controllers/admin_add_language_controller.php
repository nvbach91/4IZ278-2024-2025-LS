<?php
require __DIR__ . "/../utils/authenticate_admin.php";

require_once __DIR__ . "/../models/LanguageDB.php";

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['code']) || empty($_POST['name'])) {
        $errors[] = "Name and Code are required fields.";
    } else {
        $languageDB = new LanguageDB();

        if ($languageDB->existsUnique(['name' => $_POST['name'], 'code' => $_POST['code']])) {
            $errors[] = "You are attempting to add unique values which already exist.";
        }

        if (empty($errors)) {
            try {
                $languageDB->insert([
                    'code' => $_POST['code'],
                    'name' => $_POST['name'],
                    'icon' => !empty($_POST['icon']) ? $_POST['icon'] : null
                ]);
                $successMessage = "The language has been successfully added to the database.";
            } catch (Exception $e) {
                $errors[] = "An unexpected error has occurred while inserting the language into the database.";
            }
        }
    }
}


require __DIR__ . "/../views/pages/admin_add_language_page.php";

?>
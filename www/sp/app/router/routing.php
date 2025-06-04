<?php

switch (trim($route, '/')) {
    case '':
    case 'home':
        require __DIR__ . '/../controllers/home_controller.php';
        break;
    case 'login':
    case 'login.php':
        require __DIR__ . '/../../public/login.php';
        break;
    case 'login-google.php':
        require __DIR__ . '/../../public/login-google.php';
        break;
    case 'oauth-callback':
        require __DIR__ . "/../../public/oauth-callback.php";
        break;
    case 'register':
        require __DIR__ . '/../../public/register.php';
        break;
    case 'verify':
        require __DIR__ . '/../../public/verify.php';
        break;
    case 'logout':
        require __DIR__ . "/../utils/logout.php";
        break;
    case 'profile':
        require __DIR__ . "/../controllers/profile_controller.php";
        break;
    case 'stats':
        require __DIR__ . "/../controllers/stats_controller.php";
        break;
    case 'game_setup_language':
        require __DIR__ . "/../controllers/game_setup_language_controller.php";
        break;
    case 'game_setup':
        require __DIR__ . "/../controllers/game_setup_controller.php";
        break;
    case 'game':
        require __DIR__ . "/../controllers/game_controller.php";
        break;
    case 'game_results':
        require __DIR__ . "/../controllers/game_results_controller.php";
        break;
    case 'change_password':
        require __DIR__ . "/../controllers/change_password_controller.php";
        break;
    case 'admin/words':
        require __DIR__ . "/../controllers/admin_words_controller.php";
        break;
    case 'words':
        require __DIR__ . "/../controllers/user_words_controller.php";
        break;
    case 'admin/word':
        require __DIR__ . "/../controllers/admin_word_controller.php";
        break;
    case 'word':
        require __DIR__ . "/../controllers/user_word_controller.php";
        break;
    case 'collections':
        require __DIR__ . "/../controllers/collections_controller.php";
        break;    
    case 'create_collection':
        require __DIR__ . "/../controllers/create_collection_controller.php";
        break;
    case 'delete_collection':
        require __DIR__ . "/../controllers/delete_collection_controller.php";
        break;
    case 'collection':
        require __DIR__ . "/../controllers/collection_controller.php";
        break;
    case 'edit_collection':
        require __DIR__ . "/../controllers/edit_collection_controller.php";
        break;
    case 'edit_word':
        require __DIR__ . "/../controllers/manager_edit_word_controller.php";
        break;
    case 'admin':
    case 'admin/':
    case 'admin/dashboard':
        require __DIR__ . '/../controllers/admin_dashboard_controller.php';
        break;
    case 'admin/languages':
        require __DIR__ . '/../controllers/admin_languages_controller.php';
        break;
    case 'admin/add_language':
        require __DIR__ . '/../controllers/admin_add_language_controller.php';
        break;
    case 'admin/edit_language':
        require __DIR__ . '/../controllers/admin_edit_language_controller.php';
        break;
    case 'admin/edit_word':
        require __DIR__ . '/../controllers/admin_edit_word_controller.php';
        break;
    case "admin/add_word":
        require __DIR__ . '/../controllers/admin_add_word_controller.php';
        break;
    case "admin/users":
        require __DIR__ . '/../controllers/admin_users_controller.php';
        break;
    case 'add_word':
        require __DIR__ . '/../controllers/manager_add_word_controller.php';
        break;
    case 'error_401':
        require __DIR__ . '/../views/errors/401.php';
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
}

?>
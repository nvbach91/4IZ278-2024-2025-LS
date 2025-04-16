<?php
$params = session_get_cookie_params();
setcookie(
    'name',
    '',
    time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
);
header("Location: /4IZ278/DU/du06/index.php");
exit;

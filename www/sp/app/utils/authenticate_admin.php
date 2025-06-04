<?php

require_once __DIR__ . "/authentication.php";

if (!isAdmin()) {
    http_response_code(401);
    $url = BASE_URL . "/error_401";
    header("Location: $url");
    exit;
}

?>
<?php

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/~zemo00/sp';
$route = str_replace($basePath, '', $request);

define('BASE_URL', '/~zemo00/sp');

require __DIR__ . "/app/router/routing.php";

?>
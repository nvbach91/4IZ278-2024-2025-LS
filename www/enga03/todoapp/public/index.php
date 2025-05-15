<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer autoloader z laravel/vendor
|
*/
require __DIR__ . '/../laravel/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap The Framework
|--------------------------------------------------------------------------
|
| Načteme app.php z laravel/bootstrap
|
*/
$app = require_once __DIR__ . '/../laravel/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Maintenance Mode Check
|--------------------------------------------------------------------------
|
| Kontrola, jestli je aplikace v maintenance módu.
| Cesta musí být relativní ke složce laravel, ne k public_html!
|
*/
if (file_exists($maintenance = __DIR__ . '/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}


/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Spustíme Kernel, zachytíme Request a pošleme Response.
|
*/
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);

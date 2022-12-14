<?php

require_once "vendor/autoload.php";

use App\Classes\DB;
use App\Classes\Response;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;
use Dotenv\Dotenv;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: *');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_ENV['ENVIRONMENT'] === 'dev') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

DB::connect();

if ($_ENV['DB_MIGRATE'] === 'true') {
    DB::migrate();
}

require_once "routes.php";

SimpleRouter::setDefaultNamespace('App\Controllers');

try {
    SimpleRouter::start();
} catch (NotFoundHttpException) {
    // route not found
    die(Response::view('not-found.html', 404));
} catch (Exception $exception) {
    // any other error
    die(Response::create([
        'error' => $exception->getMessage()
    ], 500));
}

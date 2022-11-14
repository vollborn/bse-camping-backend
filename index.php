<?php

require_once "vendor/autoload.php";

use App\Classes\DB;
use App\Classes\Response;
use Pecee\SimpleRouter\SimpleRouter;
use Dotenv\Dotenv;

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
} catch (Exception $exception) {
    die($exception->getMessage());
}

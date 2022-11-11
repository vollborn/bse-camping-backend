<?php

require_once "vendor/autoload.php";

use App\Classes\DB;
use Pecee\SimpleRouter\SimpleRouter;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

DB::connect();

if ($_ENV['DB_MIGRATE'] === 'true') {
    DB::migrate();
}

require_once "routes.php";

SimpleRouter::setDefaultNamespace('App\Controllers');
SimpleRouter::start();

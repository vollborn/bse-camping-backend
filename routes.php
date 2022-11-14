<?php

use App\Controllers\CustomerController;
use Pecee\SimpleRouter\SimpleRouter;

$url = $_ENV['URL_PREFIX'];

SimpleRouter::get($url . '/customers', [CustomerController::class, 'index']);
SimpleRouter::get($url . '/customers/show', [CustomerController::class, 'show']);
SimpleRouter::post($url . '/customers', [CustomerController::class, 'store']);
SimpleRouter::put($url . '/customers', [CustomerController::class, 'update']);
SimpleRouter::delete($url . '/customers', [CustomerController::class, 'delete']);

<?php

use App\Controllers\PitchController;
use App\Controllers\CustomerController;
use Pecee\SimpleRouter\SimpleRouter;

$url = $_ENV['URL_PREFIX'];

SimpleRouter::get($url . '/customers', [CustomerController::class, 'index']);
SimpleRouter::get($url . '/customers/show', [CustomerController::class, 'show']);
SimpleRouter::post($url . '/customers', [CustomerController::class, 'store']);
SimpleRouter::put($url . '/customers', [CustomerController::class, 'update']);
SimpleRouter::delete($url . '/customers', [CustomerController::class, 'delete']);

SimpleRouter::get($url . '/pitches', [PitchController::class, 'index']);
SimpleRouter::get($url . '/pitches/show', [PitchController::class, 'show']);
SimpleRouter::post($url . '/pitches', [PitchController::class, 'store']);
SimpleRouter::put($url . '/pitches', [PitchController::class, 'update']);
SimpleRouter::delete($url . '/pitches', [PitchController::class, 'delete']);
<?php

use App\Controllers\PitchController;
use App\Controllers\CustomerController;
use App\Controllers\AdditionalCostController;
use App\Controllers\BookingController;
use App\Controllers\PersonController;
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

SimpleRouter::get($url . '/additional-costs', [AdditionalCostController::class, 'index']);
SimpleRouter::get($url . '/additional-costs/show', [AdditionalCostController::class, 'show']);
SimpleRouter::post($url . '/additional-costs', [AdditionalCostController::class, 'store']);
SimpleRouter::put($url . '/additional-costs', [AdditionalCostController::class, 'update']);
SimpleRouter::delete($url . '/additional-costs', [AdditionalCostController::class, 'delete']);

SimpleRouter::get($url . '/bookings', [BookingController::class, 'index']);
SimpleRouter::get($url . '/bookings/show', [BookingController::class, 'show']);
SimpleRouter::post($url . '/bookings', [BookingController::class, 'store']);
SimpleRouter::put($url . '/bookings', [BookingController::class, 'update']);
SimpleRouter::delete($url . '/bookings', [BookingController::class, 'delete']);

SimpleRouter::get($url . '/persons', [PersonController::class, 'index']);
SimpleRouter::get($url . '/persons/show', [PersonController::class, 'show']);
SimpleRouter::post($url . '/persons', [PersonController::class, 'store']);
SimpleRouter::put($url . '/persons', [PersonController::class, 'update']);
SimpleRouter::delete($url . '/persons', [PersonController::class, 'delete']);
<?php

use App\Controllers\AdditionalCostController;
use App\Controllers\AdditionalCostTypeController;
use App\Controllers\BookingController;
use App\Controllers\BookingPersonController;
use App\Controllers\BookingPriceController;
use App\Controllers\CountryController;
use App\Controllers\CustomerController;
use App\Controllers\LoginController;
use App\Controllers\PersonController;
use App\Controllers\PitchController;
use App\Middlewares\AuthMiddleware;
use Pecee\SimpleRouter\SimpleRouter;

$url = $_ENV['URL_PREFIX'];

$empty = static function () {
    // empty callback
};

SimpleRouter::post($url . '/login', [LoginController::class, 'login']);

SimpleRouter::group([
    'middleware' => AuthMiddleware::class
], static function () use ($url, $empty) {
    SimpleRouter::get($url . '/countries', [CountryController::class, 'index']);
    SimpleRouter::get($url . '/additional-cost-types', [AdditionalCostTypeController::class, 'index']);

    SimpleRouter::get($url . '/customers', [CustomerController::class, 'index']);
    SimpleRouter::get($url . '/customers/show', [CustomerController::class, 'show']);
    SimpleRouter::post($url . '/customers', [CustomerController::class, 'store']);
    SimpleRouter::put($url . '/customers', [CustomerController::class, 'update']);
    SimpleRouter::delete($url . '/customers', [CustomerController::class, 'delete']);
    SimpleRouter::options($url . '/customers', $empty);

    SimpleRouter::get($url . '/pitches', [PitchController::class, 'index']);
    SimpleRouter::get($url . '/pitches/show', [PitchController::class, 'show']);
    SimpleRouter::post($url . '/pitches', [PitchController::class, 'store']);
    SimpleRouter::put($url . '/pitches', [PitchController::class, 'update']);
    SimpleRouter::delete($url . '/pitches', [PitchController::class, 'delete']);
    SimpleRouter::options($url . '/pitches', $empty);

    SimpleRouter::get($url . '/additional-costs', [AdditionalCostController::class, 'index']);
    SimpleRouter::get($url . '/additional-costs/show', [AdditionalCostController::class, 'show']);
    SimpleRouter::post($url . '/additional-costs', [AdditionalCostController::class, 'store']);
    SimpleRouter::put($url . '/additional-costs', [AdditionalCostController::class, 'update']);
    SimpleRouter::delete($url . '/additional-costs', [AdditionalCostController::class, 'delete']);
    SimpleRouter::options($url . '/additional-costs', $empty);

    SimpleRouter::get($url . '/bookings', [BookingController::class, 'index']);
    SimpleRouter::get($url . '/bookings/show', [BookingController::class, 'show']);
    SimpleRouter::post($url . '/bookings', [BookingController::class, 'store']);
    SimpleRouter::put($url . '/bookings', [BookingController::class, 'update']);
    SimpleRouter::delete($url . '/bookings', [BookingController::class, 'delete']);
    SimpleRouter::options($url . '/bookings', $empty);

    SimpleRouter::get($url . '/bookings/persons', [BookingPersonController::class, 'index']);
    SimpleRouter::get($url . '/bookings/price', [BookingPriceController::class, 'show']);

    SimpleRouter::get($url . '/persons', [PersonController::class, 'index']);
    SimpleRouter::get($url . '/persons/show', [PersonController::class, 'show']);
    SimpleRouter::post($url . '/persons', [PersonController::class, 'store']);
    SimpleRouter::put($url . '/persons', [PersonController::class, 'update']);
    SimpleRouter::delete($url . '/persons', [PersonController::class, 'delete']);
    SimpleRouter::options($url . '/persons', $empty);
});

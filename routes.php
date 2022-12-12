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
use App\Controllers\PitchRequestController;
use App\Middlewares\AuthMiddleware;
use Pecee\SimpleRouter\SimpleRouter;

$url = $_ENV['URL_PREFIX'];

$empty = static function () {
    // empty callback
};

SimpleRouter::post($url . '/login', [LoginController::class, 'login']);
SimpleRouter::options($url . '/login', [LoginController::class, 'login']);

SimpleRouter::get($url . '/pitch-request', [PitchRequestController::class, 'index']);
SimpleRouter::options($url . '/pitch-request', [PitchRequestController::class, 'index']);

SimpleRouter::group([
    'middleware' => AuthMiddleware::class
], static function () use ($url) {
    function get($uri, $callback): void
    {
        SimpleRouter::options($uri, $callback);
        SimpleRouter::get($uri, $callback);
    }

    function post($uri, $callback): void
    {
        SimpleRouter::options($uri, $callback);
        SimpleRouter::post($uri, $callback);
    }

    function put($uri, $callback): void
    {
        SimpleRouter::options($uri, $callback);
        SimpleRouter::put($uri, $callback);
    }

    function delete($uri, $callback): void
    {
        SimpleRouter::options($uri, $callback);
        SimpleRouter::delete($uri, $callback);
    }

    get($url . '/countries', [CountryController::class, 'index']);
    get($url . '/additional-cost-types', [AdditionalCostTypeController::class, 'index']);

    get($url . '/customers', [CustomerController::class, 'index']);
    get($url . '/customers/show', [CustomerController::class, 'show']);
    post($url . '/customers', [CustomerController::class, 'store']);
    put($url . '/customers', [CustomerController::class, 'update']);
    delete($url . '/customers', [CustomerController::class, 'delete']);

    get($url . '/pitches', [PitchController::class, 'index']);
    get($url . '/pitches/show', [PitchController::class, 'show']);
    post($url . '/pitches', [PitchController::class, 'store']);
    put($url . '/pitches', [PitchController::class, 'update']);
    delete($url . '/pitches', [PitchController::class, 'delete']);

    get($url . '/additional-costs', [AdditionalCostController::class, 'index']);
    get($url . '/additional-costs/show', [AdditionalCostController::class, 'show']);
    post($url . '/additional-costs', [AdditionalCostController::class, 'store']);
    put($url . '/additional-costs', [AdditionalCostController::class, 'update']);
    delete($url . '/additional-costs', [AdditionalCostController::class, 'delete']);

    get($url . '/bookings', [BookingController::class, 'index']);
    get($url . '/bookings/show', [BookingController::class, 'show']);
    post($url . '/bookings', [BookingController::class, 'store']);
    put($url . '/bookings', [BookingController::class, 'update']);
    delete($url . '/bookings', [BookingController::class, 'delete']);

    get($url . '/bookings/persons', [BookingPersonController::class, 'index']);
    get($url . '/bookings/price', [BookingPriceController::class, 'show']);

    get($url . '/persons', [PersonController::class, 'index']);
    get($url . '/persons/show', [PersonController::class, 'show']);
    post($url . '/persons', [PersonController::class, 'store']);
    put($url . '/persons', [PersonController::class, 'update']);
    delete($url . '/persons', [PersonController::class, 'delete']);
});

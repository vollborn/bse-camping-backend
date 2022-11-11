<?php

use App\Controllers\CustomerController;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/customers', [CustomerController::class, 'index']);
SimpleRouter::get('/customers/show', [CustomerController::class, 'show']);
SimpleRouter::post('/customers', [CustomerController::class, 'store']);
SimpleRouter::put('/customers', [CustomerController::class, 'update']);
SimpleRouter::delete('/customers', [CustomerController::class, 'delete']);

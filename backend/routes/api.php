<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\DashboardController;

Route::post('/login', [
    AuthController::class,
    'login'
]);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/tickets', [
        TicketController::class,
        'index'
    ]);

    Route::get('/tickets/{ticket}', [
        TicketController::class,
        'show'
    ]);

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ]);

});
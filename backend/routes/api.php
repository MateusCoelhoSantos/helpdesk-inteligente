<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\NotificationController;


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

    Route::get('/user', function (Request $request) {
        return response()->json(
            $request->user()
        );
    });

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);

    Route::post(
        '/tickets',
        [TicketController::class, 'store']
    );

    Route::put(
        '/tickets/{ticket}',
        [TicketController::class, 'update']
    );

    Route::delete(
        '/tickets/{ticket}',
        [TicketController::class, 'destroy']
    );

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    );

    Route::patch(
        '/notifications/{notification}/read',
        [NotificationController::class, 'markAsRead']
    );

    Route::patch(
        '/notifications/read-all',
        [NotificationController::class, 'markAllAsRead']
    );

});
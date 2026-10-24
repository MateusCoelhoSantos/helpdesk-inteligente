<?php

use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\DashboardController;

Route::get(
    '/tickets',
    [TicketController::class, 'index']
);

Route::get(
    '/tickets/{ticket}',
    [TicketController::class, 'show']
);
Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
);
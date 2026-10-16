<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return redirect()->route('tickets.index');
});

Route::resource('tickets', TicketController::class);
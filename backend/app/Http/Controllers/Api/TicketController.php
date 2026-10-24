<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;

class TicketController extends Controller
{
    public function index()
    {
        return TicketResource::collection(
            Ticket::latest()->paginate(15)
        );
    }

    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }
}
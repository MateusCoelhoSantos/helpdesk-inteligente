<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryResource;

class HistoryController extends Controller
{
    public function index(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return HistoryResource::collection(
            $ticket->histories()
                ->with('user:id,name')
                ->latest()
                ->paginate(20)
        );
    }
}
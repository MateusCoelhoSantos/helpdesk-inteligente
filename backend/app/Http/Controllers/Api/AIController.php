<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AI\TicketClassifierService;

class AIController extends Controller
{
    public function classifyTicket(
        Request $request,
        TicketClassifierService $classifier
    ) {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        return response()->json(
            $classifier->classify(
                $validated['title'],
                $validated['description']
            )
        );
    }
}
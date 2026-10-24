<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'description' => $this->description,

            'category' => $this->category,

            'category_label' => $this->category_label,

            'priority' => $this->priority,

            'priority_label' => $this->priority_label,

            'status' => $this->status,

            'status_label' => $this->status_label,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

            'resolved_at' => $this->resolved_at,

            'resolution_time' => $this->resolution_time,
        ];
    }
}
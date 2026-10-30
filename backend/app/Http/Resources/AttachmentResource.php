<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'original_name' => $this->original_name,

            'file_path' => $this->file_path,

            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
            ],

            'created_at' => $this->created_at,
        ];
    }
}
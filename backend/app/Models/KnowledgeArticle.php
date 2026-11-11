<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeArticle extends Model
{
    protected $fillable = [
        'ticket_id',
        'title',
        'problem',
        'cause',
        'solution',
        'prevention',
    ];

    public function ticket()
    {
        return $this->belongsTo(
            Ticket::class
        );
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AIGeneration extends Model
{

    protected $table = 'ai_generations';
    
    protected $fillable = [
        'ticket_id',
        'type',
        'status',
        'result',
        'error',
    ];

    protected $casts = [
        'result' => 'array',
    ];

    public const TYPE_SUMMARY = 'summary';

    public const TYPE_KNOWLEDGE_ARTICLE = 'knowledge_article';

    public const TYPE_CLOSURE_REPORT = 'closure_report';

    public function ticket()
    {
        return $this->belongsTo(
            Ticket::class
        );
    }
}
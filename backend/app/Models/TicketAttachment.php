<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketAttachment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ticket_id',
        'user_id',
        'original_name',
        'file_path',
        'comment_id',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(
            TicketComment::class,
            'comment_id'
        );
    }
}
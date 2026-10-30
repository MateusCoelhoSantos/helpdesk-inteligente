<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketComment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(
            TicketAttachment::class,
            'comment_id'
        );
    }
}
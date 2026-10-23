<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'priority',
        'status',
        'user_id',
        'assigned_to',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'Baixa',
            'medium' => 'Média',
            'high' => 'Alta',
            'critical' => 'Crítica',
            default => $this->priority,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'Aberto',
            'in_progress' => 'Em andamento',
            'waiting' => 'Aguardando',
            'resolved' => 'Resolvido',
            default => $this->status,
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'hardware' => 'Hardware',
            'software' => 'Software',
            'network' => 'Rede',
            'access' => 'Acesso e Permissões',
            'other' => 'Outro',
            null => 'Não definida',
            default => $this->category,
        };
    }

    public function assignedUser()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }
    public function histories()
    {
        return $this->hasMany(TicketHistory::class)
            ->latest();
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class)
            ->oldest();
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class)
            ->whereNull('comment_id')
            ->latest();
    }

}
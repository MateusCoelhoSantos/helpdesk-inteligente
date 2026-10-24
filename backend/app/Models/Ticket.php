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
        'resolved_at',
        'user_id',
        'assigned_to',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function getSlaLabelAttribute(): ?string
    {
        if (!$this->resolved_at) {
            return null;
        }

        $minutes = $this->created_at
            ->diffInMinutes($this->resolved_at);

        if ($minutes <= 240) {
            return 'Dentro do SLA';
        }

        if ($minutes <= 1440) {
            return 'Próximo do limite';
        }

        return 'Fora do SLA';
    }

    public function getSlaStatusAttribute(): ?string
    {
        if (!$this->resolved_at) {
            return null;
        }

        $minutes = $this->created_at
            ->diffInMinutes($this->resolved_at);

        if ($minutes <= 240) {
            return 'success';
        }

        if ($minutes <= 1440) {
            return 'warning';
        }

        return 'danger';
    }

    public function getResolutionTimeAttribute(): ?string
    {
        if (!$this->resolved_at) {
            return null;
        }

        $minutes = $this->created_at
            ->diffInMinutes($this->resolved_at);

        $days = floor($minutes / 1440);
        $hours = floor(($minutes % 1440) / 60);
        $mins = $minutes % 60;

        return trim(
            ($days ? "{$days}d " : '') .
            ($hours ? "{$hours}h " : '') .
            "{$mins}min"
        );
    }

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
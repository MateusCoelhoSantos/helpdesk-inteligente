<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'priority',
        'status',
    ];

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

}
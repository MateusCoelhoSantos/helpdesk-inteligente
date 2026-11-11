<?php

namespace App\Services\AI\Prompts;

use App\Models\Ticket;

class TicketClosurePrompt
{
    public static function make(
        Ticket $ticket
    ): string {

        $comments = $ticket
            ->comments
            ->pluck('message')
            ->implode("\n");

        return <<<PROMPT
        Você é um analista de suporte técnico.

        Retorne APENAS JSON válido.

        Formato:

        {
            "incident_summary": "",
            "root_cause": "",
            "solution": "",
            "lessons_learned": ""
        }

        Regras:
        - Não utilize markdown.
        - Não utilize blocos ```json.
        - Não adicione texto antes ou depois do JSON.
        - Baseie-se nas informações do ticket e comentários.
        
        Considere os comentários mais recentes como a fonte principal da resolução.

        Caso a causa raiz não esteja claramente descrita, informe "Não identificada".

        Caso não exista solução registrada, informe "Não registrada".

        Título:
        {$ticket->title}

        Descrição:
        {$ticket->description}

        Status:
        {$ticket->status}

        Categoria:
        {$ticket->category}

        Comentários:
        {$comments}
        PROMPT;
    }
}
<?php

namespace App\Services\AI\Prompts;

use App\Models\Ticket;

class TicketKnowledgePrompt
{
    public static function make(
        Ticket $ticket
    ): string {

        $comments = $ticket
            ->comments
            ->pluck('message')
            ->implode("\n");

        return <<<PROMPT
        Você é um especialista em documentação técnica.

        Retorne APENAS JSON válido.

        Formato:

        {
            "title": "",
            "problem": "",
            "cause": "",
            "solution": "",
            "prevention": ""
        }

        Regras:
        - Não use markdown.
        - Não use blocos ```json.
        - Não cite usuários.
        - Não cite datas.
        - Não cite nomes de técnicos.
        - Gere conteúdo reutilizável para uma base de conhecimento.

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
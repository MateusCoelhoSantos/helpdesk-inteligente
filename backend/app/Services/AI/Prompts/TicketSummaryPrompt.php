<?php

namespace App\Services\AI\Prompts;

use App\Models\Ticket;

class TicketSummaryPrompt
{
    public static function make(
        Ticket $ticket
    ): string {

        $comments = $ticket
            ->comments
            ->map(
                fn ($comment) => $comment->message
            )
            ->implode("\n");

        return <<<PROMPT
            Você é um analista de suporte técnico.

            Gere um resumo executivo do ticket destacando:

            - problema relatado
            - diagnóstico realizado
            - causa identificada
            - status atual

            Retorne apenas um parágrafo.

            IMPORTANTE:
            - Utilize as informações dos comentários.
            - Priorize diagnósticos, análises e soluções encontradas.
            - Não use markdown.
            - Não use títulos.
            - Retorne apenas o resumo final.

            Ticket:

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

            dd($prompt);
    }
}
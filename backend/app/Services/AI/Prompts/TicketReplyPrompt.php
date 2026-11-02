<?php

namespace App\Services\AI\Prompts;

use App\Models\Ticket;

class TicketReplyPrompt
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

        Gere uma resposta profissional para o cliente.

        Considere:
        - título
        - descrição
        - status
        - categoria
        - comentários técnicos

        Regras:
        - Seja profissional.
        - Seja objetivo.
        - Não utilize Markdown.
        - Não invente informações.
        - Não crie soluções que não estejam descritas no ticket.
        - Limite a resposta a 5 linhas.
        - Assine como "Equipe de Suporte".
        - Não utilize listas.
        - Baseie-se apenas nas informações do ticket.
        - Retorne apenas o texto da resposta.
        - Não utilize agradecimentos.
        - Não utilize assinaturas.
        - Gere uma atualização de ticket.
        - Não escreva como um e-mail.

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
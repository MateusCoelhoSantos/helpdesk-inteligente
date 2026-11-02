<?php

namespace App\Services\AI\Prompts;

class TicketReplyPrompt
{
    public static function make(
        string $message
    ): string {

        return <<<PROMPT
        Você é um analista de suporte técnico.

        Gere uma resposta profissional para o usuário.

        Regras:
        - Seja educado.
        - Seja objetivo.
        - Limite a resposta a 5 linhas.
        - Assine como "Equipe de Suporte".
        - Não utilize markdown.
        - Não invente informações.
        - Retorne apenas a resposta.

        Mensagem do usuário:

        {$message}
        PROMPT;
    }
}
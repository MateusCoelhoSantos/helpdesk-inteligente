<?php

namespace App\Services\AI\Prompts;

class TicketClassificationPrompt
{
    public static function make(
        string $title,
        string $description
    ): string {

        return sprintf(
            '
            Você é um especialista em helpdesk.

            Categorias permitidas:
            - hardware
            - software
            - network
            - access
            - other

            Prioridades permitidas:
            Prioridades:

            low:
            - dúvidas
            - solicitações simples
            - melhorias
            - problemas sem impacto operacional

            medium:
            - problema individual
            - impacto limitado a um usuário
            - existe alternativa temporária

            high:
            - sistema crítico indisponível
            - múltiplos usuários afetados
            - interrupção de negócio
            - falha de infraestrutura

            critical:
            - interrupção de negócio crítico
            - falha de infraestrutura crítica
            


            Título:
            %s

            Descrição:
            %s

            Retorne SOMENTE JSON válido:

            {
                "category": "",
                "priority": "",
                "confidence": 0.0
            }
            ',
            $title,
            $description
        );
    }
}
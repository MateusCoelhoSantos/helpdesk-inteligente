<?php

namespace App\Services\AI;

class ReplySuggestionService
{
    public function suggest(string $message): string
    {
        $message = strtolower($message);

        if (
            str_contains($message, 'outlook') ||
            str_contains($message, 'email')
        ) {
            return 'Verifique a conectividade de rede, as credenciais da conta e reinicie o cliente de email.';
        }

        if (
            str_contains($message, 'impressora')
        ) {
            return 'Verifique se a impressora está ligada, conectada à rede e definida como padrão.';
        }

        if (
            str_contains($message, 'internet') ||
            str_contains($message, 'rede')
        ) {
            return 'Teste a conectividade do equipamento e confirme as configurações de rede.';
        }

        return 'Coletar mais informações do usuário antes de prosseguir com o atendimento.';
    }
}
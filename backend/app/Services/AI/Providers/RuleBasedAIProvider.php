<?php

namespace App\Services\AI\Providers;

use App\Models\Ticket;
use App\Services\AI\Contracts\AIProvider;

class RuleBasedAIProvider implements AIProvider
{
    public function classify(
        string $title,
        string $description
    ): array {

        $text = strtolower($title.' '.$description);

        return [
            'category' => $this->detectCategory($text),
            'priority' => $this->detectPriority($text),
            'confidence' => 0.85,
        ];
    }

    public function summarize(
        Ticket $ticket
    ): string {
        $commentsCount = $ticket->comments()->count();

        $historyCount = $ticket->histories()->count();

        return sprintf(
            'Chamado "%s" (%s). Possui %s comentário(s), %s registro(s) de histórico e status atual "%s".',
            $ticket->title,
            $ticket->category,
            $commentsCount,
            $historyCount,
            $ticket->status
        );
    }

    public function suggestReply(
        Ticket $ticket
    ): string {

        $message = strtolower(
            $ticket->title . ' ' . $ticket->description
        );

        if (
            str_contains($message, 'outlook') ||
            str_contains($message, 'email')
        ) {
            return 'Verifique a conectividade de rede, as credenciais da conta e reinicie o cliente de email.';
        }

        if (str_contains($message, 'impressora')) {
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


    private function detectCategory(string $text): string
    {
        if (
            str_contains($text, 'impressora') ||
            str_contains($text, 'scanner')
        ) {
            return 'hardware';
        }

        if (
            str_contains($text, 'rede') ||
            str_contains($text, 'internet')
        ) {
            return 'network';
        }

        if (
            str_contains($text, 'email') ||
            str_contains($text, 'outlook')
        ) {
            return 'software';
        }

        return 'general';
    }

    private function detectPriority(string $text): string
    {
        if (
            str_contains($text, 'urgente') ||
            str_contains($text, 'parado')
        ) {
            return 'high';
        }

        return 'medium';
    }

    public function generateKnowledgeArticle(
        Ticket $ticket
    ): array {

        return [
            'title' => $ticket->title,
            'problem' => $ticket->description,
            'cause' => 'Não identificada',
            'solution' => 'Não registrada',
            'prevention' => 'Não registrada',
        ];
    }

    public function generateClosureReport(
        Ticket $ticket
    ): array {

        return [
            'incident_summary' => '',
            'root_cause' => '',
            'solution' => '',
            'lessons_learned' => '',
        ];
    }
}
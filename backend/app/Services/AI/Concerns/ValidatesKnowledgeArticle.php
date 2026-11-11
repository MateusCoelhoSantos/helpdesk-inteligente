<?php

namespace App\Services\AI\Concerns;

trait ValidatesKnowledgeArticle
{
    protected function validateKnowledgeArticle(
        array $data
    ): array {

        return [
            'title' => $data['title'] ?? '',
            'problem' => $data['problem'] ?? '',
            'cause' => $data['cause'] ?? '',
            'solution' => $data['solution'] ?? '',
            'prevention' => $data['prevention'] ?? '',
        ];
    }
}
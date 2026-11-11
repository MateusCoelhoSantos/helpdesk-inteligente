<?php

namespace App\Services\AI\Concerns;

trait ValidatesClassification
{
    protected function validateClassification(
        array $data
    ): array {

        $categories = [
            'hardware',
            'software',
            'network',
            'access',
            'other',
        ];

        $priorities = [
            'low',
            'medium',
            'high',
            'critical',
        ];

        if (! in_array(
            $data['category'] ?? '',
            $categories
        )) {
            $data['category'] = 'other';
        }

        if (! in_array(
            $data['priority'] ?? '',
            $priorities
        )) {
            $data['priority'] = 'medium';
        }

        return $data;
    }
}
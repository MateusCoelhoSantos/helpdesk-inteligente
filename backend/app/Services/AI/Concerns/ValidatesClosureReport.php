<?php

namespace App\Services\AI\Concerns;

trait ValidatesClosureReport
{
    protected function validateClosureReport(
        array $data
    ): array {

        return [
            'incident_summary' => $data['incident_summary'] ?? '',
            'root_cause'       => $data['root_cause'] ?? '',
            'solution'         => $data['solution'] ?? '',
            'lessons_learned'  => $data['lessons_learned'] ?? '',
        ];
    }
}
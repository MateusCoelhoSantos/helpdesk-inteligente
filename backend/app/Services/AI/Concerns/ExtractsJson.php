<?php

namespace App\Services\AI\Concerns;

trait ExtractsJson
{
    protected function extractJson(
        string $content
    ): array {

        preg_match(
            '/\{.*\}/s',
            $content,
            $matches
        );

        $json = $matches[0] ?? '{}';

        return json_decode(
            $json,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
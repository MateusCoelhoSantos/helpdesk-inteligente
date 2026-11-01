<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Provider
    |--------------------------------------------------------------------------
    |
    | Providers disponíveis:
    | - rule-based
    | - openai (futuro)
    | - ollama (futuro)
    |
    */

    'provider' => env(
        'AI_PROVIDER',
        'rule-based'
    ),

    'openai' => [

        'api_key' => env(
            'OPENAI_API_KEY'
        ),

        'model' => env(
            'OPENAI_MODEL',
            'gpt-4o-mini'
        ),
    ],
];
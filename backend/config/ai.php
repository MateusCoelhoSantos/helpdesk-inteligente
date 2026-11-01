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

];
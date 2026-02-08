<?php

return [
    'public_key' => env('MOYASAR_PUBLIC_KEY'),
    'secret_key' => env('MOYASAR_SECRET_KEY'),
    'base_url'   => env('MOYASAR_BASE_URL', 'https://api.moyasar.com/v1'),
    // Optional shared secret for webhook authentication.
    // If set, Moyasar webhook requests must include header: X-Moyasar-Webhook-Token
    'webhook_token' => env('MOYASAR_WEBHOOK_TOKEN'),
];

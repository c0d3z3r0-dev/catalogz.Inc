<?php

return [
    'paynow' => [
        'id' => env('PAYNOW_ID'),
        'key' => env('PAYNOW_KEY'),
    ],
    'whatsapp' => [
        'token' => env('WHATSAPP_TOKEN'),
        'phone_id' => env('WHATSAPP_PHONE_ID'),
    ],
    'admin_whatsapp' => env('ADMIN_WHATSAPP', '0715670833'),
];

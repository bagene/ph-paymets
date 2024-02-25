<?php

return [
    'xendit' => [
        'is_production' => env('XENDIT_IS_PRODUCTION', false),
        'secret_key' => env('XENDIT_SECRET_KEY'),
        'webhook_token' => env('XENDIT_WEBHOOK_TOKEN'),
        'default_currency' => 'PHP',
        'payment_methods' => [
            "CREDIT_CARD",
            "7ELEVEN",
            "CEBUANA",
            "DD_BPI",
            "DD_UBP",
            "DD_RCBC",
            "DD_BDO_EPAY",
            "DP_MLHUILLIER",
            "DP_PALAWAN",
            "DP_ECPAY_LOAN",
            "PAYMAYA",
            "GRABPAY",
            "GCASH",
            "SHOPEEPAY",
            "BILLEASE",
            "CASHALO"
        ],
    ],

    'maya' => [
        'is_production' => env('MAYA_IS_PRODUCTION', false),
        'public_key' => env('MAYA_PUBLIC_KEY'),
        'secret_key' => env('MAYA_SECRET_KEY'),
        'use_kount' => env('MAYA_USE_KOUNT', false),
    ],
];

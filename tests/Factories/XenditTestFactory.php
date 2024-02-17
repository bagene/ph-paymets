<?php

namespace Bagene\PhPayments\Tests\Factories;

final class XenditTestFactory
{
    public const CREATE_INVOICE_DATA = [
        'external_id' => 'invoice-external-id',
        'payer_email' => 'test@example.org',
        'description' => 'Test invoice',
        'amount' => 100000,
    ];

    public const INVOICE_RESPONSE = '{
        "id":"invoice-id", 
        "external_id":"invoice-external-id",
        "payer_email":"test@example.org",
        "status": "PENDING",
        "merchant_name":"Bagene",
        "amount":100000,
        "description":"Test invoice",
        "expiry_date":"2021-12-31T23:59:59.999Z",
        "invoice_url":"https://invoice-url",
        "currency":"IDR",
        "created":"2021-01-01T00:00:00.000Z",
        "updated":"2021-01-01T00:00:00.000Z",
        "items":[]
    }';

    public const CREATE_QR_DATA = [
        'reference_id' => 'qr-reference-id',
        'type' => 'DYNAMIC',
        'callback_url' => 'https://example.org/callback',
        'currency' => 'IDR',
        'amount' => 100000,
    ];

    public const QR_RESPONSE = '{
        "id":"qr-id",
        "reference_id":"qr-reference-id",
        "type":"DYNAMIC",
        "currency":"IDR",
        "amount":100000,
        "status":"ACTIVE",
        "channel_code":"ID_DANA",
        "qr_string":"qr-string",
        "expires_at":"2021-12-31T23:59:59.999Z",
        "created":"2021-01-01T00:00:00.000Z",
        "updated":"2021-01-01T00:00:00.000Z",
        "basket":[]
    }';

    public const TOKEN_RESPONSE = '{
        "id": "5fcd8deb93e9a90020d8fd2d",
        "masked_card_number": "445653XXXXXX1096",
        "authentication_id": "5fcd8deb93e9a90020d8fd2e",
        "status": "IN_REVIEW",
        "card_info": {
            "bank": "PT. Bank Rakyat Indonesia (Persero)",
            "country": "ID",
            "type": "CREDIT",
            "brand": "VISA"
        },
        "payer_authentication_url": "https://redirect-staging.xendit.co/redirects/authentications/bundled/5fcd8deb93e9a90020d8fd2d?api_key=xnd_public_development_bPgL7lc65YTfywEk10f5qneRuu537yonRbfgQRMBLPUr1mZP4nNVd7iNHU"
    }';
}

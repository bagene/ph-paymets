<?php

namespace Bagene\PhPayments\Tests\Factories;

final class XenditTestFactory
{
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
}

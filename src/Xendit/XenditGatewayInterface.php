<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\PaymentGatewayInferface;

interface XenditGatewayInterface extends PaymentGatewayInferface
{
    const SANDBOX_BASE_URL = 'https://api.xendit.co';
    const PRODUCTION_BASE_URL = 'https://api.xendit.co';
    const INVOICE_ENDPOINT = '/v2/invoices';
    const INVOICE_PAYLOAD_REQUIRED_KEYS = [
        'external_id',
        'payer_email',
        'description',
        'amount',
        'callback_virtual_account_id',
    ];
}

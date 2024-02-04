<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Requests\BaseRequest;

interface XenditRequestInterface
{
    const PAYMENT_GATEWAY_NAME = 'xendit';
    const SANDBOX_BASE_URL = 'https://api.xendit.co';
    const PRODUCTION_BASE_URL = 'https://api.xendit.co/live';
    const INVOICE_ENDPOINT = '/v2/invoices';
    const INVOICE_EXPIRE_ENDPOINT = '/invoices';
    const QR_ENDPOINT = '/qr_codes';
}

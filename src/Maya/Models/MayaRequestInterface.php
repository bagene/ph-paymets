<?php

namespace Bagene\PhPayments\Maya\Models;

interface MayaRequestInterface
{
    const PAYMENT_GATEWAY_NAME = 'maya';
    const SANDBOX_BASE_URL = 'https://pg-sandbox.paymaya.com';
    const PRODUCTION_BASE_URL = 'https://pg.paymaya.com';
    const CHECKOUT_ENDPOINT = '/v1/checkouts';
    const WALLET_PAYMENT_ENDPOINT = '/payby/v2/paymaya/payments';
}

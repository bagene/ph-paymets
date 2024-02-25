<?php

namespace Bagene\PhPayments\Maya\Models;

interface MayaRequest
{
    const SANDBOX_BASE_URL = 'https://pg-sandbox.paymaya.com';
    const PRODUCTION_BASE_URL = 'https://api.maya.com/live';
    const CHECKOUT_ENDPOINT = '/checkout/v1/checkouts';
    const WALLET_ENDPOINT = '/payby/v2/paymaya/payments';
    const TOKEN_ENDPOINT = 'payments/v1/payment-tokens';
    const PAYMENT_ENDPOINT = '/payments/v1/payments';
    const CUSTOMER_ENDPOINT = '/payments/v1/customers';
}

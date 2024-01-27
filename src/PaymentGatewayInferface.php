<?php

namespace Bagene\PhPayments;

interface PaymentGatewayInferface
{
    const SANDBOX_BASE_URL = '';
    const PRODUCTION_BASE_URL = '';
    public function __construct(array $args = []);
    public static function initGateway();
    public function authenticate();
    public function createInvoice(?array $data = []);
}

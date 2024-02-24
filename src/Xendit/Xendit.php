<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\Gateway;
use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Traits\HttpRequest;
use Bagene\PhPayments\Xendit\Models;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;

/**
 * Class Xendit
 * @package Bagene\PhPayments\Xendit
 */
class Xendit implements Gateway
{
    use HttpRequest;
    protected const GATEWAY_NAME = 'Xendit';
    protected string $method = 'Create';
    protected string $model = '';

    public function __construct(protected XenditGatewayInterface $gateway)
    {
    }

    public function invoice(): self
    {
        $this->model = 'Invoice';
        return $this;
    }

    public function qr(): self
    {
        $this->model = 'Qr';
        return $this;
    }
}

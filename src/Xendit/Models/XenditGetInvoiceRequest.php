<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Helpers\HostResolver;
use Bagene\PhPayments\Requests\Request;
use Bagene\PhPayments\Exceptions\RequestException;
use GuzzleHttp\Exception\GuzzleException;

class XenditGetInvoiceRequest extends Request implements XenditRequestInterface
{
    public function setDefaults(): void
    {
        $this->defaults = [];
    }

    public function getEndpoint(): string
    {
        return HostResolver::resolve(
            'Xendit',
            boolval(config('payments.xendit.use_sandbox'))
        ) . self::INVOICE_ENDPOINT;
    }

    public function getMethod(): string
    {
        return 'GET';
    }
}

<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Requests\Request;

class XenditGetInvoiceRequest extends Request implements XenditRequestInterface
{
    public function setDefaults(): void
    {
        $this->defaults = [];
    }

    public function getEndpoint(): string
    {
        $host = static::PRODUCTION_BASE_URL;
        if (config('payments.xendit.use_sandbox')) {
            $host = static::SANDBOX_BASE_URL;
        }

        return $host . static::INVOICE_ENDPOINT;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function send(): XenditInvoiceResponse
    {
        // TODO: Validate the request body

        $response = parent::sendRequest(); // TODO: Change the autogenerated stub

        return new XenditInvoiceResponse($response);
    }
}

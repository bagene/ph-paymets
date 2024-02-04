<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Requests\Request;

class XenditQRRequest extends Request implements XenditRequestInterface
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

        return $host . static::QR_ENDPOINT;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function send(): XenditQRResponse
    {
        // TODO: Validate the request body

        $response = parent::sendRequest();

        return new XenditQRResponse($response);
    }
}

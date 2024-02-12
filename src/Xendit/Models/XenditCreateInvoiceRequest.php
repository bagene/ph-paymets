<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Requests\Request;
use GuzzleHttp\Exception\GuzzleException;

class XenditCreateInvoiceRequest extends Request implements XenditRequestInterface
{
    public function setDefaults(): void
    {
        $this->defaults = [
            'payment_methods' => config('payments.xendit.payment_methods')
                ?? $args['payment_methods'] ?? [],
            'currency' => config('payments.xendit.default_currency')
                ?? $args['default_currency'] ?? ''
        ];
        $this->body = array_merge($this->defaults, $this->body);
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
        return 'POST';
    }

    /**
     * @return XenditInvoiceResponse
     * @throws RequestException
     * @throws GuzzleException
     */
    public function send(): XenditInvoiceResponse
    {
        $this->validate(...$this->requiredFields);

        $response = parent::sendRequest();

        return new XenditInvoiceResponse($response);
    }

    protected function setRequireFields(): void
    {
        $this->requiredFields = [
            'external_id',
            'amount',
        ];
    }
}

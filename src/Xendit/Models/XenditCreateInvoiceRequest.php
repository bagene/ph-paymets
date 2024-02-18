<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Requests\Request;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @property-read array<string, list<string|null>> $headers
 * @property-read array{
 *     external_id: string,
 *     amount: int,
 *     payer_email?: string,
 *     description?: string,
 *     ...
 * } $body
 * @property-read array{
 *     payment_methods: string[],
 *     currency: string,
 * } $defaults
 */
class XenditCreateInvoiceRequest extends Request implements XenditRequestInterface
{
    public function setDefaults(): void
    {
        $this->defaults = [
            'payment_methods' => config('payments.xendit.payment_methods')
                ?? [],
            'currency' => config('payments.xendit.default_currency')
                ?? ''
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
     * @return string[]
     */
    protected function getRequiredFields(): array
    {
        return [
            'external_id',
            'amount',
        ];
    }
}

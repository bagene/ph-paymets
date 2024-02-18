<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Requests\BaseResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

interface PaymentGatewayInferface
{
    public function setAttribute(string $name, mixed $value): PaymentGatewayInferface;
    /** @param array<string, mixed> $attributes */
    public function setAttributes(array $attributes): PaymentGatewayInferface;

    /**
     * PaymentGateway constructor.
     * For Laravel, argument would be optional and will be filled with config('payments')
     * For non-Laravel, argument would be required
     */
    public function __construct(?Client $client = null);

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array;

    /**
     * Authenticate to the gateway
     * @return void
     */
    public function authenticate(): void;

    /**
     * Get invoice by ID or external ID
     * @throws RequestException
     * @throws GuzzleException
     */
    public function getInvoice(string $id = '', ?string $externalId = null): ?BaseResponse;
    /**
     * Create invoice
     * @param array<string, mixed> $data
     * @throws RequestException
     * @throws GuzzleException
     */
    public function createInvoice(array $data = []): ?BaseResponse;

    /**
     * Validate and Parse Webhook payload
     * @return array<string, mixed>
     */
    public function parseWebhookPayload(Request $request): array;
}

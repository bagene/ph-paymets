<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Requests\BaseResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

interface PaymentGatewayInferface
{
    /**
     * PaymentGateway constructor.
     * For Laravel, argument would be optional and will be filled with config('payments')
     * For non-Laravel, argument would be required
     */
    public function __construct(array $args = [], ?Client $client = null);
    public function getHeaders();
    public static function getGateway(string $gateway, array $args = []): PaymentGateway;

    /**
     * Initialize gateway statically (without constructor)
     */
    public static function initGateway(?array $args = []): self;

    /**
     * Authenticate to the gateway
     * @return void
     */
    public function authenticate(): void;

    /**
     * Get invoice by ID or external ID
     */
    public function getInvoice(string $id = '', ?string $externalId = null): BaseResponse;
    /**
     * Create invoice
     */
    public function createInvoice(?array $data = []): BaseResponse;

    /**
     * Validate and Parse Webhook payload
     */
    public function parseWebhookPayload(Request|array $request, ?array $headers): array;
}

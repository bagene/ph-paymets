<?php

namespace Bagene\PhPayments;

use Illuminate\Http\Request;

interface PaymentGatewayInferface
{
    /**
     * PaymentGatewayInferface constructor.
     * For Laravel, argument would be optional and will be filled with config('payments')
     * For non-Laravel, argument would be required
     * @param array $args
     */
    public function __construct(array $args = []);

    /**
     * Initialize gateway statically (without constructor)
     * @return self
     */
    public static function initGateway(?array $args = []): self;

    /**
     * Authenticate to the gateway
     * @return void
     */
    public function authenticate(): void;

    /**
     * Get invoice by ID or external ID
     * @param string $id
     * @param string|null $externalId
     * @return array
     */
    public function getInvoice(string $id = '', ?string $externalId = null): array;
    /**
     * Create invoice
     * @param array|null $data
     * @return array
     */
    public function createInvoice(?array $data = []): array;

    /**
     * Cancel invoice
     * @param string $id
     * @return array
     */
    public function cancelInvoice(string $id): array;

    /**
     * Validate and Parse Webhook payload
     * @param Request|array $request
     * @param array|null $headers
     * @return array
     */
    public function parseWebhookPayload(Request|array $request, ?array $headers): array;
}

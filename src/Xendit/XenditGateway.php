<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\AbstractGateway;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;

class XenditGateway extends AbstractGateway implements XenditGatewayInterface
{
    use XenditPayloadValidator;
    protected string $secretKey;
    protected string $webhookKey;
    protected string $apiKey;
    public function __construct(array $args = [])
    {
        $this->secretKey = config('payments.xendit.secret_key') ?? $args['secret_key'] ?? '';
        $this->webhookKey = config('payments.xendit.webhook_token') ?? $args['webhook_token'] ?? '';
        $this->authenticate();
    }

    public static function initGateway()
    {
        return new self();
    }

    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];
    }

    public function authenticate(): void
    {
        $this->apiKey = base64_encode($this->secretKey . ':');
    }

    public function createInvoice(?array $data = [])
    {
        // TODO: Implement createPayment() method.
        $this->validateXenditPayload($data);

        $response = $this->sendRequest(
            'POST',
            $this->getEndpoint(static::INVOICE_ENDPOINT),
            $data
        );

        return $response;
    }
}

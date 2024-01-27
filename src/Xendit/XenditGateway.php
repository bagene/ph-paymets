<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\PaymentGateway;
use Illuminate\Http\Request;

final class XenditGateway extends PaymentGateway implements XenditGatewayInterface
{
    use XenditTraits;
    protected string $secretKey;
    protected string $webhookKey;
    protected string $apiKey;
    protected array $paymentMethods;
    protected string $defaultCurrency;
    final public function __construct(array $args = [])
    {
        $this->secretKey = config('payments.xendit.secret_key') ?? $args['secret_key'] ?? '';
        $this->webhookKey = config('payments.xendit.webhook_token') ?? $args['webhook_token'] ?? '';
        $this->paymentMethods = config('payments.xendit.payment_methods') ?? $args['payment_methods'] ?? [];
        $this->defaultCurrency = config('payments.xendit.default_currency') ?? $args['default_currency'] ?? '';
        $this->authenticate();
    }

    final public static function initGateway(?array $args = []): self
    {
        return new self($args);
    }

    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];
    }

    final public function authenticate(): void
    {
        $this->apiKey = base64_encode($this->secretKey . ':');
    }

    final public function getInvoice(string $id = '', ?string $externalId = null): array
    {
        if (!empty($externalId)) {
            return $this->sendRequest(
                'GET',
                $this->getEndpoint(static::INVOICE_ENDPOINT),
                ['external_id' => $externalId]
            );
        }

        return $this->sendRequest(
            'GET',
            $this->getEndpoint(static::INVOICE_ENDPOINT . '/' . $id)
        );
    }

    final public function createInvoice(?array $data = []): array
    {
        $this->validateXenditPayload($data);
        $data = array_merge($data, [
            'payment_methods' => $data['payment_methods'] ?? $this->paymentMethods,
            'currency' => $data['currency'] ?? $this->defaultCurrency,
        ]);

        return $this->sendRequest(
            'POST',
            $this->getEndpoint(static::INVOICE_ENDPOINT),
            $data
        );
    }

    final public function cancelInvoice(string $id): array
    {
        return $this->sendRequest(
            'POST',
            $this->getEndpoint(static::INVOICE_EXPIRE_ENDPOINT . '/' . $id . '/expire!')
        );
    }

    final public function parseWebhookPayload(array|Request $request, ?array $headers = []): array
    {
        $headers = parent::parseWebhookPayload($request, $headers);

        if ($headers['x-callback-token'] !== $this->webhookKey) {
            throw new \InvalidArgumentException('Invalid webhook token');
        }

        if ($request instanceof Request) {
            $webhookId = $request->get('webhook-id');
            $this->cacheWebhookId($webhookId, 'xendit-webhook');
            return $request->all();
        }

        $webhookId = $request['webhook-id'];
        $this->cacheWebhookId($webhookId, 'xendit-webhook', false);

        return $request;
    }

    public function createQR(array $data): string
    {
        $this->validatePayload('QR_PAYLOAD_REQUIRED_KEYS', $data);
        return $this->sendRequest(
            'POST',
            $this->getEndpoint(static::QR_ENDPOINT),
            $data
        )['qr_string'] ?? '';
    }
}

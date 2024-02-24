<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\PaymentGateway;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

final class XenditGateway extends PaymentGateway implements XenditGatewayInterface
{
    public string $secretKey;
    public string $webhookKey;
    public string $apiKey;
    final public function __construct()
    {
        /** @var string $secretKey */
        $secretKey = config('payments.xendit.secret_key', '');
        $this->secretKey = $secretKey;

        /** @var string $webhookKey */
        $webhookKey = config('payments.xendit.webhook_token', '');
        $this->webhookKey = $webhookKey;

        $this->authenticate();
    }

    /**
     * @return array{Authorization: string, Content-Type: string}
     */
    public function getHeaders(): array
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

    /**
     * @return array<string, list<string|null>>
     * @throws RequestException
     */
    final protected function verifyWebhook(Request $request): array
    {
        if (empty($request->headers->get(self::WEBHOOK_HEADER_KEYS))
        ) {
            throw new RequestException('Missing required header: '.self::WEBHOOK_HEADER_KEYS);
        }

        return $request->headers->all();
    }

    /**
     * @return array<string, mixed>
     * @throws RequestException
     */
    final public function parseWebhookPayload(Request $request): array
    {
        $headers = $this->verifyWebhook($request);

        if ($headers['x-callback-token'][0] != $this->webhookKey) {
            throw new RequestException('Invalid webhook token');
        }

        $webhookId = $request->get('webhook-id');

        $this->cacheWebhookId('xendit-webhook-'.$webhookId);
        return $request->all();
    }
}

<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceRequest;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceRequest;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditQRRequest;
use Bagene\PhPayments\Xendit\Models\XenditQRResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

final class XenditGateway extends PaymentGateway implements XenditGatewayInterface
{
    use XenditTraits;
    protected string $secretKey;
    protected string $webhookKey;
    protected string $apiKey;
    protected array $paymentMethods;
    protected string $defaultCurrency;
    final public function __construct(array $args = [], ?Client $client = null)
    {
        parent::__construct($args, $client);
        $this->secretKey = config('payments.xendit.secret_key') ?? $args['secret_key'] ?? '';
        $this->webhookKey = config('payments.xendit.webhook_token') ?? $args['webhook_token'] ?? '';
        $this->authenticate();
    }

    final public static function initGateway(?array $args = []): self
    {
        return new self($args);
    }

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

    final public function getInvoice(string $id = '', ?string $externalId = null): XenditInvoiceResponse
    {
        $request = new XenditGetInvoiceRequest($this->getHeaders(), ['external_id' => $externalId]);
        return $request->send();
    }

    final public function createInvoice(?array $data = []): XenditInvoiceResponse
    {
        $this->validateXenditPayload($data);
        $request = new XenditCreateInvoiceRequest($this->getHeaders(), $data);
        return $request->send();
    }

    final public function parseWebhookPayload(array|Request $request, ?array $headers = []): array
    {
        $headers = parent::parseWebhookPayload($request, $headers);

        if ($headers['x-callback-token'][0] != $this->webhookKey) {
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

    public function createQR(array $data): XenditQRResponse
    {
        $request = new XenditQRRequest($this->getHeaders(), $data);
        return $request->send();
    }
}

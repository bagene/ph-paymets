<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceRequest;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceRequest;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditQrRequest;
use Bagene\PhPayments\Xendit\Models\XenditQrResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

final class XenditGateway extends PaymentGateway implements XenditGatewayInterface
{
    public string $secretKey;
    public string $webhookKey;
    public string $apiKey;
    final public function __construct(?Client $client = null)
    {
        parent::__construct($client);
        $this->secretKey = config('payments.xendit.secret_key') ?? '';
        $this->webhookKey = config('payments.xendit.webhook_token') ?? '';
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

    final public function getInvoice(string $id = '', ?string $externalId = null): XenditGetInvoiceResponse
    {
        $request = new XenditGetInvoiceRequest(
            $this->getHeaders(),
            ['external_id' => $externalId]
        );

        /** @var XenditGetInvoiceResponse $response */
        $response = $request->send();

        return $response;
    }

    /**
     * @param array{
     *     amount: int,
     *     currency: string,
     *     external_id: string,
     *     ...
     * }|array{} $data
     * @return XenditCreateInvoiceResponse
     * @throws RequestException
     * @throws GuzzleException
     */
    final public function createInvoice(array $data = []): XenditCreateInvoiceResponse
    {
        $request = new XenditCreateInvoiceRequest(
            $this->getHeaders(),
            $data
        );

        /** @var XenditCreateInvoiceResponse $response */
        $response = $request->send();

        return $response;
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

    /** @inheritDoc */
    public function createQR(array $data): XenditQrResponse
    {
        $request = new XenditQrRequest(
            $this->getHeaders(),
            $data,
        );

        /** @var XenditQrResponse $response */
        $response = $request->send();

        return $response;
    }
}

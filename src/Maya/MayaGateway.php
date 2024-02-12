<?php

namespace Bagene\PhPayments\Maya;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Maya\Models\MayaCreateInvoiceRequest;
use Bagene\PhPayments\Maya\Models\MayaInvoiceResponse;
use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\Xendit\Models\XenditQRResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class MayaGateway extends PaymentGateway implements MayaGatewayInterface
{
    protected string $publicKey;
    protected string $secretKey;
    protected string $apiKey;
    final public function __construct(array $args = [], ?Client $client = null)
    {
        parent::__construct($args, $client);
        $this->publicKey = config('payments.maya.public_key') ?? $args['public_key'] ?? '';
        $this->secretKey = config('payments.maya.secret_key') ?? $args['secret_key'] ?? '';
        $this->authenticate();
    }

    public function authenticate(): void
    {
        $this->apiKey = base64_encode($this->publicKey . ':' . $this->secretKey);
    }

    public function getHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @throws RequestException
     * @throws GuzzleException
     */
    public function createInvoice(?array $data = []): MayaInvoiceResponse
    {
        $request = new MayaCreateInvoiceRequest($this->getHeaders(), $data);
        return $request->send();
    }

    public function getInvoice(string $id = '', ?string $externalId = null): ?MayaInvoiceResponse
    {
        return null;
    }

    public function verifyWebhook(array|Request $request, ?array $headers = []): array
    {
        // TODO: Implement verifyWebhook() method.
        return [];
    }

    public function parseWebhookPayload(array|Request $request, ?array $headers = []): array
    {
        // TODO: Implement parseWebhookPayload() method.
        return [];
    }
}

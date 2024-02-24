<?php

namespace Bagene\PhPayments\Maya;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Maya\Models\MayaCreateInvoiceRequest;
use Bagene\PhPayments\Maya\Models\MayaInvoiceResponse;
use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class MayaGateway extends PaymentGateway implements MayaGatewayInterface
{
    protected string $publicKey;
    protected string $secretKey;
    protected string $apiKey;
    final public function __construct()
    {
        /** @var string $publicKey */
        $publicKey = config('payments.maya.public_key', '');
        $this->publicKey = $publicKey;

        /** @var string $secretKey */
        $secretKey = config('payments.maya.secret_key', '');
        $this->secretKey = $secretKey;

        $this->authenticate();
    }

    public function authenticate(): void
    {
        $this->apiKey = base64_encode($this->publicKey . ':' . $this->secretKey);
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

    /**
     * @param array{
     *     amount: int,
     *     currency: string,
     *     external_id: string,
     *     ...
     * }|array{} $data
     * @return MayaInvoiceResponse
     * @throws RequestException
     * @throws GuzzleException
     */
    public function createInvoice(array $data = []): MayaInvoiceResponse
    {
        $request = new MayaCreateInvoiceRequest($this->getHeaders(), $data);
        return $request->send();
    }

    public function getInvoice(string $id = '', ?string $externalId = null): ?MayaInvoiceResponse
    {
        return null;
    }

    /**
     * @return array<string, list<string|null>>
     */
    public function verifyWebhook(Request $request): array
    {
        // TODO: Implement verifyWebhook() method.
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    public function parseWebhookPayload(Request $request): array
    {
        // TODO: Implement parseWebhookPayload() method.
        return [];
    }
}

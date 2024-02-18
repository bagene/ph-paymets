<?php

namespace Bagene\PhPayments\Xendit;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceResponse;
use GuzzleHttp\Exception\GuzzleException;

interface XenditGatewayInterface extends PaymentGatewayInferface
{
    const PAYMENT_GATEWAY_NAME = 'xendit';
    const SANDBOX_BASE_URL = 'https://api.xendit.co';
    const PRODUCTION_BASE_URL = 'https://api.xendit.co/live';
    const INVOICE_ENDPOINT = '/v2/invoices';
    const INVOICE_EXPIRE_ENDPOINT = '/invoices';
    const QR_ENDPOINT = '/qr_codes';
    const INVOICE_PAYLOAD_REQUIRED_KEYS = [
        'external_id',
        'amount',
    ];
    const QR_PAYLOAD_REQUIRED_KEYS = [
        'reference_id',
        'type'
    ];
    const WEBHOOK_HEADER_KEYS = 'x-callback-token';

    /**
     * Get invoice by ID or external ID
     * @throws RequestException
     * @throws GuzzleException
     */
    public function getInvoice(string $id = '', ?string $externalId = null): XenditGetInvoiceResponse;
    /**
     * Create invoice
     * @param array<string, mixed> $data
     * @throws RequestException
     * @throws GuzzleException
     */
    public function createInvoice(array $data = []): XenditCreateInvoiceResponse;

    /**
     * Create QR
     * @param array{
     *     reference_id: string,
     *     type: string,
     *     currency: string,
     *     amount?: int,
     *     ...
     * } $data
     * @throws RequestException
     * @throws GuzzleException
     */
    public function createQR(array $data): BaseResponse;
}

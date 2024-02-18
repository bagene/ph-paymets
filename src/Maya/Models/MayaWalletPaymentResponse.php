<?php

namespace Bagene\PhPayments\Maya\Models;

use Psr\Http\Message\ResponseInterface;

/**
 * @property-read array{
 *     paymentId: string
 * } $body
 */
class MayaWalletPaymentResponse extends MayaInvoiceResponse
{
    protected string $paymentId;
    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);
        $this->paymentId = $this->body['paymentId'];
    }
}

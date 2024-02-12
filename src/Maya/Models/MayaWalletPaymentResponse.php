<?php

namespace Bagene\PhPayments\Maya\Models;

use Psr\Http\Message\ResponseInterface;

class MayaWalletPaymentResponse extends MayaInvoiceResponse
{
    protected string $paymentId;
    public function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);
        $this->paymentId = $this->body['paymentId'];
    }
}

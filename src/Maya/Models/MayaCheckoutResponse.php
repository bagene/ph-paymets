<?php

namespace Bagene\PhPayments\Maya\Models;

use Psr\Http\Message\ResponseInterface;

final class MayaCheckoutResponse extends MayaInvoiceResponse
{
    protected string $checkoutId;
    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);

        $this->checkoutId = $this->body['checkoutId'];
    }

    public function getCheckoutId(): string
    {
        return $this->checkoutId;
    }
}
<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @property-read array{
 *    paymentId: string,
 *    redirectUrl: string
 * } $body
 */
class MayaCreateWalletResponse extends Response
{
    protected string $paymentId;
    protected string $redirectUrl;

    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);

        $this->paymentId = $this->body['paymentId'];
        $this->redirectUrl = $this->body['redirectUrl'];
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }
}

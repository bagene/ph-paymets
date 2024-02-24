<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @property-read array{
 *    checkoutId: string,
 *    redirectUrl: string
 * } $body
 */
final class MayaCreateCheckoutResponse extends Response
{
    protected string $checkoutId;
    protected string $redirectUrl;
    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);

        $this->checkoutId = $this->body['checkoutId'];
        $this->redirectUrl = $this->body['redirectUrl'];
    }

    public function getCheckoutId(): string
    {
        return $this->checkoutId;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }
}

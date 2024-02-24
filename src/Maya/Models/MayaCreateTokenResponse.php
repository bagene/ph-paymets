<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @property-read array{
 *    paymentTokenId: string,
 *    state: string,
 *    createdAt: string,
 *    updatedAt: string,
 *    issuer: string
 * } $body
 */
final class MayaCreateTokenResponse extends Response
{
    protected string $paymentTokenId;
    protected string $state;
    protected string $createdAt;
    protected string $updatedAt;
    protected string $issuer;

    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);

        $this->paymentTokenId = $this->body['paymentTokenId'];
        $this->state = $this->body['state'];
        $this->createdAt = $this->body['createdAt'];
        $this->updatedAt = $this->body['updatedAt'];
        $this->issuer = $this->body['issuer'];
    }

    public function getPaymentTokenId(): string
    {
        return $this->paymentTokenId;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }
}

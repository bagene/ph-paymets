<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Requests\Response;
use http\Url;
use Psr\Http\Message\ResponseInterface;

/**
 * Xendit QR Response
 * @link https://xendit.github.io/apireference/?shell#qr-code
 * @property-read array{
 *     id: string,
 *     reference_id: string,
 *     type: string,
 *     currency: string,
 *     amount: float,
 *     status: string,
 *     channel_code: string,
 *     qr_string: string,
 *     expires_at: string,
 *     created: string,
 *     updated: string,
 *     basket: array{
 *     reference_id: string,
 *     name: string,
 *     category: string,
 *     currency: string,
 *     price: float,
 *     quantity: int,
 *     type: string,
 *     url: string,
 *     description: string,
 *     sub-category: string,
 *     metadata: array{...},
 *     }|null,
 *     ...
 * } $body
 */
class XenditQrResponse extends Response implements BaseResponse
{
    public string $id;
    public string $referenceId;
    public string $type;
    public string $currency;
    public float $amount;
    public string $status;
    public string $channelCode;
    public string $qrString;
    public string $expiresAt;
    public string $created;
    public string $updated;
    /** @var array{
     * reference_id: string,
     * name: string,
     * category: string,
     * currency: string,
     * price: float,
     * quantity: int,
     * type: string,
     * url: string,
     * description: string,
     * sub-category: string,
     * metadata: array{...},
     * }|null $basket */
    public ?array $basket;
    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);

        $this->id = $this->body['id'];
        $this->referenceId = $this->body['reference_id'];
        $this->type = $this->body['type'];
        $this->currency = $this->body['currency'];
        $this->amount = $this->body['amount'];
        $this->status = $this->body['status'];
        $this->channelCode = $this->body['channel_code'];
        $this->qrString = $this->body['qr_string'];
        $this->expiresAt = $this->body['expires_at'];
        $this->created = $this->body['created'];
        $this->updated = $this->body['updated'];
        $this->basket = $this->body['basket'];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getReferenceId(): string
    {
        return $this->referenceId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getChannelCode(): string
    {
        return $this->channelCode;
    }

    public function getQrString(): string
    {
        return $this->qrString;
    }

    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    public function getUpdated(): string
    {
        return $this->updated;
    }

    /**
     * @return array{
     * reference_id: string,
     * name: string,
     * category: string,
     * currency: string,
     * price: float,
     * quantity: int,
     * type: string,
     * url: string,
     * description: string,
     * sub-category: string,
     * metadata: array{...},
     * }|null
     */
    public function getBasket(): ?array
    {
        return $this->basket;
    }
}

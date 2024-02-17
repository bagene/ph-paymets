<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

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
    public array $basket;
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

    public function getBasket(): array
    {
        return $this->basket;
    }
}

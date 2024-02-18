<?php

namespace Bagene\PhPayments\Xendit\Models;

use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @property-read array{
 *     id: string,
 *     external_id: string,
 *     status: string,
 *     merchant_name: string,
 *     amount: float,
 *     payer_email: string,
 *     description: string,
 *     expiry_date: string,
 *     invoice_url: string,
 *     currency: string,
 *     created: string,
 *     updated: string,
 *     items: array{
 *         name: string,
 *         price: float,
 *         quantity: int,
 *         category: string,
 *         url: string,
 *     }[]|null,
 * } $body
 */
class XenditInvoiceResponse extends Response implements BaseResponse
{
    protected string $id;
    protected string $externalId;
    protected string $status;
    protected string $merchantName;
    protected float $amount;
    protected string $payerEmail;
    protected string $description;
    protected string $expiryDate;
    protected string $invoiceUrl;
    protected string $currency;
    protected string $created;
    protected string $updated;
    /**
     * @var array{
     *     name: string,
     *     price: float,
     *     quantity: int,
     *     category: string,
     *     url: string,
     * }[]|null $items
     */
    protected ?array $items;

    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);

        $this->id = $this->body['id'];
        $this->externalId = $this->body['external_id'];
        $this->status = $this->body['status'];
        $this->merchantName = $this->body['merchant_name'];
        $this->amount = $this->body['amount'];
        $this->payerEmail = $this->body['payer_email'];
        $this->description = $this->body['description'];
        $this->expiryDate = $this->body['expiry_date'];
        $this->invoiceUrl = $this->body['invoice_url'];
        $this->expiryDate = $this->body['expiry_date'];
        $this->invoiceUrl = $this->body['invoice_url'];
        $this->currency = $this->body['currency'];
        $this->created = $this->body['created'];
        $this->updated = $this->body['updated'];
        $this->items = $this->body['items'];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMerchantName(): string
    {
        return $this->merchantName;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getPayerEmail(): string
    {
        return $this->payerEmail;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getExpiryDate(): string
    {
        return $this->expiryDate;
    }

    public function getInvoiceUrl(): string
    {
        return $this->invoiceUrl;
    }

    public function getCreated(): string
    {
        return $this->created;
    }


    public function getUpdated(): string
    {
        return $this->updated;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return array{
     *     name: string,
     *     price: float,
     *     quantity: int,
     *     category: string,
     *     url: string,
     * }[]|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }
}

<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @property-read array{
 *     id: string,
 *     isPaid: bool,
 *     status: string,
 *     amount: float,
 *     currency: string,
 *     canVoid: bool,
 *     canRefund: bool,
 *     canCapture: bool,
 *     createdAt: string,
 *     updatedAt: string,
 *     requestReferenceNumber?: string,
 *     description?: string,
 *     paymentTokenId?: string,
 *     verificationUrl?: string,
 *     fundSource?: array,
 *     batchNumber?: string,
 *     traceNumber?: string,
 *     emvIccData?: string,
 *     receipt?: array,
 *     approvalCode?: string,
 *     receiptNumber?: string,
 *     authorizationType?: string,
 *     capturedAmount?: float,
 *     authorizationPayment?: string,
 *     capturedPaymentId?: string,
 *     subscription?: string,
 *     metadata?: array
 * } $body
 */
class MayaCreatePaymentResponse extends Response
{
    protected string $id;
    protected bool $isPaid;
    protected string $status;
    protected float $amount;
    protected string $currency;
    protected bool $canVoid;
    protected bool $canRefund;
    protected bool $canCapture;
    protected string $createdAt;
    protected string $updatedAt;
    protected ?string $requestReferenceNumber;
    protected ?string $description;
    protected ?string $paymentTokenId;
    protected ?string $verificationUrl;
    /** @var array<string, mixed>|null */
    protected ?array $fundSource;
    protected ?string $batchNumber;
    protected ?string $traceNumber;
    protected ?string $emvIccData;
    /** @var array<string, mixed>|null */
    protected ?array $receipt;
    protected ?string $approvalCode;
    protected ?string $receiptNumber;
    protected ?string $authorizationType;
    protected ?float $capturedAmount;
    protected ?string $authorizationPayment;
    protected ?string $capturedPaymentId;
    protected ?string $subscription;
    /** @var array<string, mixed>|null */
    protected ?array $metadata;

    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);
        $this->id = $this->body['id'];
        $this->isPaid = $this->body['isPaid'];
        $this->status = $this->body['status'];
        $this->amount = $this->body['amount'];
        $this->currency = $this->body['currency'];
        $this->canVoid = $this->body['canVoid'];
        $this->canRefund = $this->body['canRefund'];
        $this->canCapture = $this->body['canCapture'];
        $this->createdAt = $this->body['createdAt'];
        $this->updatedAt = $this->body['updatedAt'];
        $this->requestReferenceNumber = $this->body['requestReferenceNumber'] ?? null;
        $this->description = $this->body['description'] ?? null;
        $this->paymentTokenId = $this->body['paymentTokenId'] ?? null;
        $this->verificationUrl = $this->body['verificationUrl'] ?? null;
        $this->fundSource = $this->body['fundSource'] ?? null;
        $this->batchNumber = $this->body['batchNumber'] ?? null;
        $this->traceNumber = $this->body['traceNumber'] ?? null;
        $this->emvIccData = $this->body['emvIccData'] ?? null;
        $this->receipt = $this->body['receipt'] ?? null;
        $this->approvalCode = $this->body['approvalCode'] ?? null;
        $this->receiptNumber = $this->body['receiptNumber'] ?? null;
        $this->authorizationType = $this->body['authorizationType'] ?? null;
        $this->capturedAmount = $this->body['capturedAmount'] ?? null;
        $this->authorizationPayment = $this->body['authorizationPayment'] ?? null;
        $this->capturedPaymentId = $this->body['capturedPaymentId'] ?? null;
        $this->subscription = $this->body['subscription'] ?? null;
        $this->metadata = $this->body['metadata'] ?? null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCanVoid(): bool
    {
        return $this->canVoid;
    }

    public function getCanRefund(): bool
    {
        return $this->canRefund;
    }

    public function getCanCapture(): bool
    {
        return $this->canCapture;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getRequestReferenceNumber(): ?string
    {
        return $this->requestReferenceNumber;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPaymentTokenId(): ?string
    {
        return $this->paymentTokenId;
    }

    public function getVerificationUrl(): ?string
    {
        return $this->verificationUrl;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getFundSource(): ?array
    {
        return $this->fundSource;
    }

    public function getBatchNumber(): ?string
    {
        return $this->batchNumber;
    }

    public function getTraceNumber(): ?string
    {
        return $this->traceNumber;
    }

    public function getEmvIccData(): ?string
    {
        return $this->emvIccData;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getReceipt(): ?array
    {
        return $this->receipt;
    }

    public function getApprovalCode(): ?string
    {
        return $this->approvalCode;
    }

    public function getReceiptNumber(): ?string
    {
        return $this->receiptNumber;
    }

    public function getAuthorizationType(): ?string
    {
        return $this->authorizationType;
    }

    public function getCapturedAmount(): ?float
    {
        return $this->capturedAmount;
    }

    public function getAuthorizationPayment(): ?string
    {
        return $this->authorizationPayment;
    }

    public function getCapturedPaymentId(): ?string
    {
        return $this->capturedPaymentId;
    }

    public function getSubscription(): ?string
    {
        return $this->subscription;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }
}

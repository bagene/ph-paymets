<?php

namespace Bagene\PhPayments\Requests;

use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface BaseResponse
 * @package Bagene\PhPayments\Requests
 */
interface BaseResponse
{
    /** @return array<string, string>|array<int, list<string>> */
    public function getHeaders(): array;

    /** @return array<string, mixed>|null */
    public function getBody(): ?array;
}

<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Exceptions\MethodNotFoundException;
use Bagene\PhPayments\Requests\BaseResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;

/**
 * Interface Gateway
 * @method string getRequestedClassName()
 */
interface Gateway
{
    /**
     * @param array<string, mixed>|array<list<mixed>> $payload
     * @throws MethodNotFoundException
     */
    public function create(array $payload): BaseResponse;

    /**
     * @param array<string, mixed>|array<list<mixed>> $payload
     */
    public function get(array $payload = []): BaseResponse;
}

<?php

namespace Bagene\PhPayments\Requests;

use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponseInterface;

interface ResponseMessage extends BaseResponse, XenditInvoiceResponseInterface
{
}

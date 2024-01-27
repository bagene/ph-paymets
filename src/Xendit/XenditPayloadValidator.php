<?php

namespace Bagene\PhPayments\Xendit;

trait XenditPayloadValidator
{
    protected function validateXenditPayload(array $data): void
    {
        $this->validatePayload('INVOICE_PAYLOAD_REQUIRED_KEYS', $data);
    }
}

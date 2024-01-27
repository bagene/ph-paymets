<?php

namespace Bagene\PhPayments\Xendit;

trait XenditTraits
{
    protected function validateXenditPayload(array $data): void
    {
        $this->validatePayload('INVOICE_PAYLOAD_REQUIRED_KEYS', $data);
    }

    protected function addDefaultInvoiceValues(array $data): array
    {
        $data['currency'] = $data['currency'] ?? $this->defaultCurrency;
        $data['payment_methods'] = $data['payment_methods'] ?? $this->paymentMethods;
        return $data;
    }
}

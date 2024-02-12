<?php

namespace Bagene\PhPayments;

final class PhPayments
{
    public function setGateway(string $gateway, array $args = []): PaymentGatewayInferface
    {
        $gateway = ucfirst($gateway);
        $gatewayClass = "Bagene\\PhPayments\\{$gateway}\\{$gateway}Gateway";
        if (!class_exists($gatewayClass)) {
            throw new \InvalidArgumentException("Invalid gateway: {$gateway}");
        }

        return new $gatewayClass($args);
    }
}

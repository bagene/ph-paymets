<?php

namespace Bagene\PhPayments;

use Illuminate\Http\Request;

final class PhPayments
{
    public function setGateway(string $gateway): PaymentGatewayInferface
    {
        $gateway = ucfirst($gateway);
        $gatewayClass = "Bagene\\PhPayments\\{$gateway}\\{$gateway}Gateway";
        if (
            !class_exists($gatewayClass)
            || !is_subclass_of($gatewayClass, PaymentGatewayInferface::class)
            || !is_callable($gatewayClass, true)
        ) {
            throw new \InvalidArgumentException("Invalid gateway: {$gateway}");
        }

        /** @var PaymentGateway $gateway */
        $gateway = new $gatewayClass();

        return $gateway;
    }
}

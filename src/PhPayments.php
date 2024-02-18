<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Maya\MayaGatewayInterface;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Illuminate\Http\Request;

final class PhPayments
{
    public function setGateway(string $gateway): PaymentGatewayInferface
    {
        switch ($gateway) {
            case 'xendit':
                return app(XenditGatewayInterface::class);
            case 'maya':
                return app(MayaGatewayInterface::class);
            default:
                throw new \InvalidArgumentException("Invalid gateway: $gateway");
        }
    }
}

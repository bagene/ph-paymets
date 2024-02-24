<?php

namespace Bagene\PhPayments;

use Bagene\PhPayments\Maya\Maya;
use Bagene\PhPayments\Maya\MayaGatewayInterface;
use Bagene\PhPayments\Xendit\Xendit;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;

final class PhPayments
{
    public function setGateway(string $gateway): PaymentGatewayInferface
    {
        switch ($gateway) {
            case 'xendit':
                /** @var XenditGatewayInterface $paymentGateway */
                $paymentGateway = app(XenditGatewayInterface::class);
                break;
            case 'maya':
                /** @var MayaGatewayInterface $paymentGateway */
                $paymentGateway = app(MayaGatewayInterface::class);
                break;
            default:
                throw new \InvalidArgumentException("Invalid gateway: $gateway");
        }

        return $paymentGateway;
    }

    public function xendit(): Xendit
    {
        /** @var XenditGatewayInterface $gateway */
        $gateway = app(XenditGatewayInterface::class);

        return new Xendit($gateway);
    }

    public function maya(): Maya
    {
        /** @var MayaGatewayInterface $gateway */
        $gateway = app(MayaGatewayInterface::class);

        return new Maya($gateway);
    }
}

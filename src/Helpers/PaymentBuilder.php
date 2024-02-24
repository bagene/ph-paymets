<?php

namespace Bagene\PhPayments\Helpers;

use Bagene\PhPayments\Maya\MayaGatewayInterface;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\PhPayments;
use Bagene\PhPayments\Xendit\Xendit;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PaymentGatewayInferface|XenditGatewayInterface setGateway(string $string)
 * @method static XenditGatewayInterface getXendidGateway()
 * @method static MayaGatewayInterface getMayaGateway()
 * @method static Xendit xendit()
 * @method static setAttribute(string $name, mixed $value)
 * @method static setAttributes(array $attributes)
 *
 * @see PhPayments
 * @see PaymentGatewayInferface
 */
class PaymentBuilder extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return PhPayments::class;
    }
}

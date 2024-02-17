<?php

namespace Bagene\PhPayments\Helpers;

use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\PhPayments;
use Illuminate\Support\Facades\Facade;

/**
 * @method static setGateway(string $string)
 */
class PaymentBuilder extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return PhPayments::class;
    }
}

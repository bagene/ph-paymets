<?php

namespace Bagene\PhPayments\Tests\Unit;

use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\PhPayments;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

class PhPaymentFacadeTest extends TestCase
{
    use WithWorkbench;

    public function testFacadeShouldReturnPaymentGateway(): void
    {
        $this->assertInstanceOf(PhPayments::class, PaymentBuilder::getFacadeRoot());
        $this->assertInstanceOf(PaymentGatewayInferface::class, PaymentBuilder::setGateway('xendit'));
    }

    public function testFacadeShouldReturnXenditGateway(): void
    {
        $this->assertInstanceOf(PhPayments::class, PaymentBuilder::getFacadeRoot());
        $this->assertInstanceOf(XenditGatewayInterface::class, PaymentBuilder::setGateway('xendit'));
    }
}

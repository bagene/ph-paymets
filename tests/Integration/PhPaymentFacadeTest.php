<?php

namespace Bagene\PhPayments\Tests\Integration;

use Bagene\PhPayments\Gateway;
use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\Maya\MayaGatewayInterface;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\PhPayments;
use Bagene\PhPayments\Tests\TestCase;
use Bagene\PhPayments\Xendit\Xendit;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Orchestra\Testbench\Concerns\WithWorkbench;

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

    public function testFacadeShouldThrowInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid gateway: NON_EXISTING_GATEWAY');

        PaymentBuilder::setGateway('NON_EXISTING_GATEWAY');
    }

    public function testFacadeShouldSetAttribute(): void
    {
        $gateway = PaymentBuilder::setGateway('xendit')
            ->setAttribute('secretKey', 'secret')
            ->setAttribute('webhookKey', 'webhook')
            ->setAttribute('apiKey', 'api_key');

        $this->assertInstanceOf(PaymentGatewayInferface::class, $gateway);
    }

    public function testFacadeShouldNotSetNonExistingAttribute(): void
    {
        $gateway = PaymentBuilder::setGateway('xendit')
            ->setAttribute('nonExistingAttribute', 'value');

        $this->assertInstanceOf(PaymentGatewayInferface::class, $gateway);
    }

    public function testFacadeShouldSetAttributes(): void
    {
        $gateway = PaymentBuilder::setGateway('xendit');
        $gateway->setAttributes([
            'secretKey' => 'secret',
            'webhookKey' => 'webhook',
            'apiKey' => 'api_key',
        ]);

        $this->assertInstanceOf(PaymentGatewayInferface::class, $gateway);
    }

    public function testXenditMethodShouldReturnXenditInstance(): void
    {
        $this->assertInstanceOf(Gateway::class, PaymentBuilder::xendit());
        $this->assertInstanceOf(Xendit::class, PaymentBuilder::xendit());
    }

}

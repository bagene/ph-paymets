<?php

declare(strict_types=1);
namespace Bagene\PhPayments\Tests\Integration;

use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\Tests\PaymentsTestCase;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Orchestra\Testbench\TestCase;

final class PaymentGatewayTest extends TestCase
{
    public function testShouldGetGateway(): void
    {
        $gateway = PaymentBuilder::setGateway('xendit');
        $this->assertInstanceOf(XenditGatewayInterface::class, $gateway);
    }

    public function testGetGatewayThrowInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid gateway: NON_EXISTING_GATEWAY');

        PaymentBuilder::setGateway('NON_EXISTING_GATEWAY');
    }

    public function testShouldSetAttribute(): void
    {
        $gateway = PaymentBuilder::setGateway('xendit');
        $gateway->setAttribute('secretKey', 'secret');
        $gateway->setAttribute('webhookKey', 'webhook');
        $gateway->setAttribute('apiKey', 'api_key');

        $this->assertInstanceOf(XenditGatewayInterface::class, $gateway);
    }

    public function testShouldSetAttributes(): void
    {
        $gateway = PaymentBuilder::setGateway('xendit');
        $gateway->setAttributes([
            'secretKey' => 'secret',
            'webhookKey' => 'webhook',
            'apiKey' => 'api_key',
        ]);

        $this->assertInstanceOf(XenditGatewayInterface::class, $gateway);
    }
}

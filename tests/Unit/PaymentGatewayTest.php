<?php

declare(strict_types=1);
namespace Bagene\PhPayments\Tests\Unit;

use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\Tests\PaymentsTestCase;
use Bagene\PhPayments\Xendit\XenditGateway;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Illuminate\Http\Request;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ServerBag;

final class PaymentGatewayTest extends \Orchestra\Testbench\TestCase
{
    public function testShouldGetGateway(): void
    {
        $this->app;
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
        $this->assertEquals('secret', $gateway->secretKey);
        $this->assertEquals('webhook', $gateway->webhookKey);
        $this->assertEquals('api_key', $gateway->apiKey);
    }

    public function testShouldSetAttributes(): void
    {
        $gateway = PaymentBuilder::setGateway('xendit');
        $gateway->setAttributes([
            'secretKey' => 'secret',
            'webhookKey' => 'webhook',
            'apiKey' => 'api_key',
        ]);
        $this->assertEquals('secret', $gateway->secretKey);
        $this->assertEquals('webhook', $gateway->webhookKey);
        $this->assertEquals('api_key', $gateway->apiKey);
    }

    public function testShouldCacheWebhookId(): void
    {
        $gateway = PaymentBuilder::setGateway('xendit');
        $gateway->cacheWebhookId('id');
        $this->assertTrue(cache()->has('webhook-id'));
    }
}

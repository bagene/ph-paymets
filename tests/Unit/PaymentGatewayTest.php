<?php

declare(strict_types=1);
namespace Bagene\PhPayments\Tests\Unit;

use Bagene\PhPayments\PaymentGateway;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\Tests\PaymentsTestCase;
use Bagene\PhPayments\Xendit\XenditGateway;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Illuminate\Http\Request;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ServerBag;

final class PaymentGatewayTest extends PaymentsTestCase
{
    public function testShouldGetGateway(): void
    {
        $gateway = PaymentGateway::getGateway('xendit');
        $this->assertInstanceOf(XenditGatewayInterface::class, $gateway);
    }

    public function testGetGatewayThrowInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid gateway: NON_EXISTING_GATEWAY');

        PaymentGateway::getGateway('NON_EXISTING_GATEWAY');
    }

    public function testValidatePayloadThrowInvalidTypeException(): void
    {
        $data = [];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type: NON_EXISTING_PAYLOAD');

        $gateway = PaymentGateway::getGateway('xendit');
        $gateway->validatePayload('NON_EXISTING_PAYLOAD', $data);
    }

    public function testValidatePayloadThrowMissingRequiredKeyException(): void
    {
        $data = ['amount' => 100];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing required key: external_id');

        $gateway = PaymentGateway::getGateway('xendit');
        $gateway->validatePayload('INVOICE_PAYLOAD_REQUIRED_KEYS', $data);
    }
}

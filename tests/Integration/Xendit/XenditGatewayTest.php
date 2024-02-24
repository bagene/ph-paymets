<?php

namespace Bagene\PhPayments\Tests\Integration\Xendit;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\PaymentGatewayInferface;
use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\ShouldMock;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;
use Bagene\PhPayments\Xendit\XenditGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

class XenditGatewayTest extends TestCase
{
    use WithWorkbench;
    use ShouldMock;

    private XenditGatewayInterface $gateway;

    public function setUp(): void
    {
        parent::setUp();

        // Set Xendit Configs
        config(['payments.xendit.use_sandbox' => true]);
        config(['payments.xendit.secret_key' => 'secret']);
        config(['payments.xendit.webhook_token' => 'token']);

        /** @var XenditGatewayInterface $gateway */
        $gateway = PaymentBuilder::setGateway('xendit');

        $this->gateway = $gateway;
    }

    public function tearDown(): void
    {

        Cache::forget('xendit-webhook-id');
    }

    public function testGetHeaders(): void
    {
        $headers = $this->gateway->getHeaders();
        $this->assertIsArray($headers);
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertEquals('Basic c2VjcmV0Og==', $headers['Authorization']);
        $this->assertEquals('application/json', $headers['Content-Type']);
    }

    public function testAuthenticate(): void
    {
        $this->gateway->authenticate();
        $this->assertEquals([
            'Authorization' => 'Basic c2VjcmV0Og==',
            'Content-Type' => 'application/json',
        ], $this->gateway->getHeaders());
    }

    public function testParseWebhook(): void
    {
        $request = Request::create(
            uri: '/webhook',
            method: 'POST',
            parameters: ['webhook-id' => 'id'],
            server: [
                'HTTP_X_CALLBACK_TOKEN' => 'token'
            ],
        );

        $result = $this->gateway->parseWebhookPayload($request);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('webhook-id', $result);
        $this->assertEquals('id', $result['webhook-id']);
        $this->assertTrue(Cache::has('xendit-webhook-id'));
    }

    public function testParseWebhookThrowsException(): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Invalid webhook token');
        $request = Request::create(
            uri: '/webhook',
            method: 'POST',
            parameters: ['webhook-id' => 'id'],
            server: [
                'HTTP_X_CALLBACK_TOKEN' => 'invalid-token'
            ],
        );

        $this->gateway->parseWebhookPayload($request);

        $this->assertFalse(Cache::has('xendit-webhook-id'));
    }

    public function testParseWebhookThrowsExceptionMissingHeader(): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Missing required header: x-callback-token');
        $request = Request::create(
            uri: '/webhook',
            method: 'POST',
            parameters: ['webhook-id' => 'id'],
        );

        $this->gateway->parseWebhookPayload($request);

        $this->assertFalse(Cache::has('xendit-webhook-id'));
    }

    public function testParseWebhookThrowsExceptionDuplicateWebhookId(): void
    {
        $request = Request::create(
            uri: '/webhook',
            method: 'POST',
            parameters: ['webhook-id' => 'id'],
            server: [
                'HTTP_X_CALLBACK_TOKEN' => 'token'
            ],
        );

        $this->gateway->parseWebhookPayload($request);
        $this->assertTrue(Cache::has('xendit-webhook-id'));

        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Duplicate webhook');

        $this->gateway->parseWebhookPayload($request);
    }
}

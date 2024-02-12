<?php

namespace Bagene\PhPayments\Tests\Unit\Xendit\Models;

use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\Unit\ShouldMock;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use Orchestra\Testbench\TestCase;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceRequest;

class XenditCreateInvoiceRequestTest extends TestCase
{
    use ShouldMock;

    public function testCreateInvoiceRequest(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $request = new XenditCreateInvoiceRequest(
            [],
            [
                'external_id' => 'invoice-external-id',
                'payer_email' => 'test@example.org',
                'description' => 'Test invoice',
                'amount' => 100000,
            ]
        );
        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());

    }

    public function testCreateInvoiceRequestWithConfig(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $request = new XenditCreateInvoiceRequest(
            [
                'payment_methods' => ['credit_card'],
                'default_currency' => 'USD',
            ],
            [
                'external_id' => 'invoice-external-id',
                'payer_email' => 'test@example.org',
                'description' => 'Test invoice',
                'amount' => 100000,
            ]
        );
        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
    }

    public function testCreateInvoiceRequestWithSandbox(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        config(['payments.xendit.use_sandbox' => true]);
        $request = new XenditCreateInvoiceRequest(
            [],
            [
                'external_id' => 'invoice-external-id',
                'payer_email' => 'test@example.org',
                'description' => 'Test invoice',
                'amount' => 100000,
            ]
        );
        $this->assertEquals('https://api.xendit.co/v2/invoices', $request->getEndpoint());

        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
    }
}

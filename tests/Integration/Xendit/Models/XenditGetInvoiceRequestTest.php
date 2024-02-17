<?php

namespace Bagene\PhPayments\Tests\Integration\Xendit\Models;

use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\ShouldMock;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceRequest;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use Orchestra\Testbench\TestCase;

class XenditGetInvoiceRequestTest extends TestCase
{
    use ShouldMock;

    public function testGetInvoiceRequest(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $request = new XenditGetInvoiceRequest(
            ['content-type' => 'application/json'],
            [
                'invoice_id' => 'invoice-id',
            ]
        );

        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge([], [
            'invoice_id' => 'invoice-id',
        ]), $request->getBody());

        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
    }

    public function testGetInvoiceRequestWithSandbox(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        config(['payments.xendit.use_sandbox' => true]);
        $request = new XenditGetInvoiceRequest(
            ['content-type' => 'application/json'],
            [
                'invoice_id' => 'invoice-id',
            ]
        );

        $this->assertEquals('https://api.xendit.co/v2/invoices', $request->getEndpoint());
        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge([], [
            'invoice_id' => 'invoice-id',
        ]), $request->getBody());

        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
    }
}

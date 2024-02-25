<?php

namespace Bagene\PhPayments\Tests\Integration\Xendit\Models;

use Bagene\PhPayments\Exceptions\RequestException;
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
                'id' => 'invoice-id',
            ]
        );

        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge([], [
            'id' => 'invoice-id',
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
                'id' => 'invoice-id',
            ]
        );

        $this->assertEquals('https://api.xendit.co/v2/invoices/invoice-id', $request->getEndpoint());
        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge([], [
            'id' => 'invoice-id',
        ]), $request->getBody());

        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
    }

    public function testGetInvoiceRequestWithExternalId(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $request = new XenditGetInvoiceRequest(
            ['content-type' => 'application/json'],
            [
                'external_id' => 'invoice-external-id',
            ]
        );

        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge([], [
            'external_id' => 'invoice-external-id',
        ]), $request->getBody());

        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
    }

    public function testGetInvoiceExpectsRequestException(): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Either id or external_id is required');
        $request = new XenditGetInvoiceRequest(
            ['content-type' => 'application/json'],
            []
        );
        $request->send();
    }
}

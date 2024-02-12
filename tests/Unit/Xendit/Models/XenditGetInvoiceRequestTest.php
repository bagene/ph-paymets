<?php

namespace Bagene\PhPayments\Tests\Unit\Xendit\Models;

use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\Unit\ShouldMock;
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
            [],
            [
                'invoice_id' => 'invoice-id',
            ]
        );
        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
    }
}

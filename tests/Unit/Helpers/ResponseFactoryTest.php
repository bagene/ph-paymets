<?php

namespace Bagene\PhPayments\Tests\Unit\Helpers;

use Bagene\PhPayments\Helpers\ResponseFactory;
use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceRequest;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\PHPUnit\TestCase;
use Psr\Http\Message\ResponseInterface;

class ResponseFactoryTest extends TestCase
{
    public function testCreateResponseReturnResponse(): void
    {
        $response = new Response(200, [], XenditTestFactory::INVOICE_RESPONSE);
        $response = ResponseFactory::createResponse(XenditInvoiceResponse::class, $response);
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
    }

    public function testCreateResponseThrowException(): void
    {
        $response = new Response(200, [], XenditTestFactory::INVOICE_RESPONSE);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Response class must be an instance of Bagene\PhPayments\Requests\Response');
        ResponseFactory::createResponse(XenditCreateInvoiceRequest::class, $response);
    }
}

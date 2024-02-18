<?php

namespace Bagene\PhPayments\Tests\Unit\Xendit\Models;

use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class XenditInvoiceResponseTest extends TestCase
{
    public function testSettersAndGetters(): void
    {
        $data = [
            'id' => 'invoice-id',
            'external_id' => 'invoice-external-id',
            'status' => 'PENDING',
            'payer_email' => 'test@email.com',
            'description' => 'Test invoice',
            'amount' => 100000,
            'merchant_name' => 'Bagene',
            'expiry_date' => '2021-12-31T23:59:59.999Z',
            'invoice_url' => 'https://invoice-url',
            'currency' => 'IDR',
            'created' => '2021-01-01T00:00:00.000Z',
            'updated' => '2021-01-01T00:00:00.000Z',
            'items' => [],
        ];
        $response = new Response(200, [], json_encode($data) ?: '{}');

        $xenditInvoiceResponse = new XenditInvoiceResponse($response);

        $this->assertIsArray($xenditInvoiceResponse->getHeaders());
        $this->assertIsArray($xenditInvoiceResponse->getBody());
        $this->assertEquals($data, $xenditInvoiceResponse->getBody());

        $this->assertEquals('invoice-id', $xenditInvoiceResponse->getId());
        $this->assertEquals('invoice-external-id', $xenditInvoiceResponse->getExternalId());
        $this->assertEquals('PENDING', $xenditInvoiceResponse->getStatus());
        $this->assertEquals('Bagene', $xenditInvoiceResponse->getMerchantName());
        $this->assertEquals(100000, $xenditInvoiceResponse->getAmount());
        $this->assertEquals('test@email.com', $xenditInvoiceResponse->getPayerEmail());
        $this->assertEquals('Test invoice', $xenditInvoiceResponse->getDescription());
        $this->assertEquals('2021-12-31T23:59:59.999Z', $xenditInvoiceResponse->getExpiryDate());
        $this->assertEquals('https://invoice-url', $xenditInvoiceResponse->getInvoiceUrl());
        $this->assertEquals('IDR', $xenditInvoiceResponse->getCurrency());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $xenditInvoiceResponse->getCreated());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $xenditInvoiceResponse->getUpdated());
        $this->assertEquals([], $xenditInvoiceResponse->getItems());
    }
}

<?php

namespace Bagene\PhPayments\Tests\Integration\Xendit;

use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\ShouldMock;
use Bagene\PhPayments\Tests\TestCase;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceResponse;

final class XenditTest extends TestCase
{
    use ShouldMock;

    public function testCreateInvoice(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $response = PaymentBuilder::xendit()
            ->invoice()
            ->create([
                'external_id' => 'invoice-external-id',
                'payer_email' => 'test@example.org',
                'description' => 'Test invoice',
                'amount' => 10000,
            ]);

        $this->assertInstanceOf(XenditCreateInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
        $this->assertEquals('PENDING', $response->getStatus());
        $this->assertEquals('Bagene', $response->getMerchantName());
        $this->assertEquals(100000, $response->getAmount());
        $this->assertEquals('test@example.org', $response->getPayerEmail());
        $this->assertEquals('Test invoice', $response->getDescription());
        $this->assertEquals('2021-12-31T23:59:59.999Z', $response->getExpiryDate());
        $this->assertEquals('https://invoice-url', $response->getInvoiceUrl());
        $this->assertEquals('IDR', $response->getCurrency());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $response->getCreated());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $response->getUpdated());
        $this->assertEquals([], $response->getItems());
    }

    public function testGetInvoice(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $response = PaymentBuilder::xendit()
            ->invoice()
            ->get('invoice-id');

        $this->assertInstanceOf(XenditGetInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
        $this->assertEquals('PENDING', $response->getStatus());
        $this->assertEquals('Bagene', $response->getMerchantName());
        $this->assertEquals(100000, $response->getAmount());
        $this->assertEquals('test@example.org', $response->getPayerEmail());
        $this->assertEquals('Test invoice', $response->getDescription());
        $this->assertEquals('2021-12-31T23:59:59.999Z', $response->getExpiryDate());
        $this->assertEquals('https://invoice-url', $response->getInvoiceUrl());
        $this->assertEquals('IDR', $response->getCurrency());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $response->getCreated());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $response->getUpdated());
        $this->assertEquals([], $response->getItems());
    }

    public function testCreateQr(): void
    {
        $this->mockResponse(XenditTestFactory::QR_RESPONSE);

        /** @var XenditCreateQrResponse $response */
        $response = PaymentBuilder::xendit()
            ->qr()
            ->create([
                'reference_id' => 'qr-reference-id',
                'type' => 'DYNAMIC',
                'callback_url' => 'https://example.org/callback',
                'currency' => 'IDR',
                'amount' => 100000,
            ]);

        $this->assertEquals('qr-id', $response->getId());
        $this->assertEquals('qr-reference-id', $response->getReferenceId());
        $this->assertEquals('DYNAMIC', $response->getType());
        $this->assertEquals('IDR', $response->getCurrency());
        $this->assertEquals(100000, $response->getAmount());
        $this->assertEquals('ACTIVE', $response->getStatus());
        $this->assertEquals('ID_DANA', $response->getChannelCode());
        $this->assertEquals('qr-string', $response->getQrString());
        $this->assertEquals('2021-12-31T23:59:59.999Z', $response->getExpiresAt());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $response->getCreated());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $response->getUpdated());
        $this->assertEquals([], $response->getBasket());
    }
}

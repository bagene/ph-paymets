<?php

namespace Bagene\PhPayments\Tests\Functional\Xendit;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\ShouldMock;
use Bagene\PhPayments\Tests\TestCase;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceResponse;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;
use Bagene\PhPayments\Xendit\Models\XenditGetInvoiceResponse;
use Bagene\PhPayments\Xendit\Xendit;

class XenditTest extends TestCase
{
    use ShouldMock;

    public function testXenditCreateInvoice(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $response = PaymentBuilder::xendit()
            ->invoice()
            ->create([
                'external_id' => 'invoice-external-id',
                'amount' => 100000,
                'payer_email' => 'test@example.org',
            ]);

        $this->assertInstanceOf(XenditCreateInvoiceResponse::class, $response);
        $this->assertNotNull($response->getInvoiceUrl());
        $this->assertNotNull($response->getId());
    }

    public function testXenditGetInvoice(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $response = PaymentBuilder::xendit()
            ->invoice()
            ->get([
                'external_id' => 'invoice-external-id',
            ]);

        $this->assertInstanceOf(XenditGetInvoiceResponse::class, $response);
        $this->assertNotNull($response->getInvoiceUrl());
        $this->assertNotNull($response->getId());
    }

    public function testXenditCreateQr(): void
    {
        $this->mockResponse(XenditTestFactory::QR_RESPONSE);

        /** @var XenditCreateQrResponse $response */
        $response = PaymentBuilder::xendit()
            ->qr()
            ->create([
                'reference_id' => 'qr-external-id',
                'type' => 'DYNAMIC',
                'callback_url' => 'https://example.org/callback',
                'currency' => 'PHP',
                'amount' => 100000,
            ]);

        $this->assertNotNull($response->getId());
        $this->assertNotNull($response->getQrString());
    }
}

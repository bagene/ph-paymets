<?php

namespace Bagene\PhPayments\Tests\Integration\Xendit\Models;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\ShouldMock;
use Bagene\PhPayments\Xendit\Models\XenditCreateInvoiceRequest;
use Bagene\PhPayments\Xendit\Models\XenditInvoiceResponse;
use Orchestra\Testbench\TestCase;

class XenditCreateInvoiceRequestTest extends TestCase
{
    use ShouldMock;

    private const DEFAULTS = [
        'payment_methods' => [],
        'currency' => '',
    ];

    public function testCreateInvoiceRequest(): void
    {
        $this->mockResponse(XenditTestFactory::INVOICE_RESPONSE);
        $request = new XenditCreateInvoiceRequest(
            ['content-type' => 'application/json'],
            XenditTestFactory::CREATE_INVOICE_DATA,
        );
        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge(self::DEFAULTS, XenditTestFactory::CREATE_INVOICE_DATA), $request->getBody());

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
            ['content-type' => 'application/json'],
            XenditTestFactory::CREATE_INVOICE_DATA,
        );
        $this->assertEquals('https://api.xendit.co/v2/invoices', $request->getEndpoint());
        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge(self::DEFAULTS, XenditTestFactory::CREATE_INVOICE_DATA), $request->getBody());

        $response = $request->send();
        $this->assertInstanceOf(XenditInvoiceResponse::class, $response);
        $this->assertEquals('invoice-id', $response->getId());
        $this->assertEquals('invoice-external-id', $response->getExternalId());
    }

    /**
     * @dataProvider provideInvalidData
     * @param array{reference_id?: string, type?: string} $data
     */
    public function testCreateInvoiceRequestExpectException(array $data, string $errorMsg): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage($errorMsg);
        $this->expectExceptionCode(422);
        $request = new XenditCreateInvoiceRequest(
            ['content-type' => 'application/json'],
            $data
        );

        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge(self::DEFAULTS, $data), $request->getBody());

        $request->send();
    }

    /**
     * @return array<string, array{0: array{
     *     reference_id?: string,
     *     type?: string,
     * }, 1: string}>
     */
    public static function provideInvalidData(): array
    {
        return [
            'empty' => [
                [],
                'Missing required fields: external_id, amount'
            ],
            'missing-external-id' => [
                [
                    'amount' => 100000,
                ],
                'Missing required fields: external_id'
            ],
            'missing-amount' => [
                [
                    'external_id' => 'invoice-external-id',
                ],
                'Missing required fields: amount'
            ],
        ];
    }

    public function testCreateInvoiceRequestExpectRequestException(): void
    {
        $this->mockResponseException('Error');
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('Error');
        $this->expectExceptionCode(500);
        $request = new XenditCreateInvoiceRequest(
            [],
            [
                'external_id' => 'invoice-external-id',
                'payer_email' => 'test@example.org',
                'description' => 'Test invoice',
                'amount' => 100000,
            ]
        );
        $request->send();
    }
}

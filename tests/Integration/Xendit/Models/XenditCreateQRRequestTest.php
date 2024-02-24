<?php

namespace Bagene\PhPayments\Tests\Integration\Xendit\Models;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Tests\Factories\XenditTestFactory;
use Bagene\PhPayments\Tests\ShouldMock;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrRequest;
use Bagene\PhPayments\Xendit\Models\XenditCreateQrResponse;
use Orchestra\Testbench\TestCase;

class XenditCreateQRRequestTest extends TestCase
{
    use ShouldMock;

    public function testCreateQRRequest(): void
    {
        $this->mockResponse(XenditTestFactory::QR_RESPONSE);
        $request = new XenditCreateQrRequest(
            ['content-type' => 'application/json'],
            XenditTestFactory::CREATE_QR_DATA,
        );

        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge([], XenditTestFactory::CREATE_QR_DATA), $request->getBody());

        $response = $request->send();
        $this->assertInstanceOf(XenditCreateQrResponse::class, $response);
        $this->assertEquals('qr-id', $response->getId());
        $this->assertEquals('qr-reference-id', $response->getReferenceId());
        $this->assertEquals('DYNAMIC', $response->getType());
        $this->assertEquals('IDR', $response->getCurrency());
        $this->assertEquals(100000, $response->getAmount());
    }

    public function testCreateQRRequestWithSandbox(): void
    {
        $this->mockResponse(XenditTestFactory::QR_RESPONSE);
        config(['payments.xendit.use_sandbox' => true]);
        $request = new XenditCreateQrRequest(
            ['content-type' => 'application/json'],
            XenditTestFactory::CREATE_QR_DATA,
        );

        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge([], XenditTestFactory::CREATE_QR_DATA), $request->getBody());

        $response = $request->send();
        $this->assertEquals('https://api.xendit.co/qr_codes', $request->getEndpoint());
        $this->assertInstanceOf(XenditCreateQrResponse::class, $response);
        $this->assertEquals('qr-id', $response->getId());
        $this->assertEquals('qr-reference-id', $response->getReferenceId());
        $this->assertEquals('DYNAMIC', $response->getType());
        $this->assertEquals('IDR', $response->getCurrency());
        $this->assertEquals(100000, $response->getAmount()); }

    /**
     * @dataProvider provideInvalidData
     * @param array{
     *     reference_id?: string,
     *     type?: string,
     *     currency?: string,
     * } $data
     * @param string $errorMsg
     */
    public function testCreateQRExpectExceptions(array $data, string $errorMsg): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage($errorMsg);
        $this->expectExceptionCode(422);
        $request = new XenditCreateQrRequest(
            ['content-type' => 'application/json'],
            $data
        );

        $this->assertIsArray($request->getHeaders());
        $this->assertArrayHasKey('content-type', $request->getHeaders());
        $this->assertIsArray($request->getBody());
        $this->assertEquals(array_merge([], $data), $request->getBody());

        $request->send();
    }

    /**
     * @return array{
     *     'empty': array{array{
     *      reference_id?: string,
     *      type?: string,
     *      currency?: string,
     *  }, string},
     * }
     */
    public static function provideInvalidData(): array
    {
        return [
            'empty' => [
                [],
                'Missing required fields: reference_id, type, currency',
            ],
            'missingReferenceId' => [
                [
                    'type' => 'DYNAMIC',
                    'currency' => 'IDR',
                ],
                'Missing required fields: reference_id',
            ],
            'missingType' => [
                [
                    'reference_id' => 'qr-reference-id',
                    'currency' => 'IDR',
                ],
                'Missing required fields: type',
            ],
            'missingCurrency' => [
                [
                    'reference_id' => 'qr-reference-id',
                    'type' => 'DYNAMIC',
                ],
                'Missing required fields: currency',
            ],
            'missingAmountForDynamic' => [
                [
                    'reference_id' => 'qr-reference-id',
                    'type' => 'STATIC',
                    'currency' => 'IDR',
                ],
                'Missing required fields: amount',
            ],
        ];
    }
}

<?php

namespace Bagene\PhPayments\Tests\Unit\Xendit\Models;

use Bagene\PhPayments\Xendit\Models\XenditQrResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class XenditQRResponseTest extends TestCase
{
    public function testSettersAndGetters(): void
    {
        $data = [
            'id' => 'qr-id',
            'reference_id' => 'qr-reference-id',
            'type' => 'DYNAMIC',
            'currency' => 'IDR',
            'amount' => 100000,
            'status' => 'ACTIVE',
            'channel_code' => 'ID_OVO',
            'qr_string' => 'qr-string',
            'expires_at' => '2021-12-31T23:59:59.999Z',
            'created' => '2021-01-01T00:00:00.000Z',
            'updated' => '2021-01-01T00:00:00.000Z',
            'basket' => [],
        ];
        $response = new Response(200, [], json_encode($data) ?: '{}');

        $xenditQRResponse = new XenditQrResponse($response);

        $this->assertIsArray($xenditQRResponse->getHeaders());
        $this->assertIsArray($xenditQRResponse->getBody());
        $this->assertEquals($data, $xenditQRResponse->getBody());

        $this->assertEquals('qr-id', $xenditQRResponse->getId());
        $this->assertEquals('qr-reference-id', $xenditQRResponse->getReferenceId());
        $this->assertEquals('DYNAMIC', $xenditQRResponse->getType());
        $this->assertEquals('IDR', $xenditQRResponse->getCurrency());
        $this->assertEquals(100000, $xenditQRResponse->getAmount());
        $this->assertEquals('ACTIVE', $xenditQRResponse->getStatus());
        $this->assertEquals('ID_OVO', $xenditQRResponse->getChannelCode());
        $this->assertEquals('qr-string', $xenditQRResponse->getQrString());
        $this->assertEquals('2021-12-31T23:59:59.999Z', $xenditQRResponse->getExpiresAt());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $xenditQRResponse->getCreated());
        $this->assertEquals('2021-01-01T00:00:00.000Z', $xenditQRResponse->getUpdated());
        $this->assertEquals([], $xenditQRResponse->getBasket());
    }
}

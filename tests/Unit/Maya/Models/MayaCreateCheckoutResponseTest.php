<?php

namespace Bagene\PhPayments\Tests\Unit\Maya\Models;

use Bagene\PhPayments\Maya\Models\MayaCreateCheckoutResponse;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\PHPUnit\TestCase;

class MayaCreateCheckoutResponseTest extends TestCase
{
    public function testCreateCheckoutResponse(): void
    {
        $response = new Response(200, [], json_encode([
            'checkoutId' => 'checkoutId',
            'redirectUrl' => 'redirectUrl',
        ]) ?: '{}');

        $checkoutResponse = new MayaCreateCheckoutResponse($response);

        $this->assertInstanceOf(MayaCreateCheckoutResponse::class, $checkoutResponse);
        $this->assertEquals('redirectUrl', $checkoutResponse->getRedirectUrl());
        $this->assertEquals('checkoutId', $checkoutResponse->getCheckoutId());
    }
}

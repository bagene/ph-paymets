<?php

namespace Bagene\PhPayments\Tests\Unit\Maya\Models;

use Bagene\PhPayments\Maya\Models\MayaCreateWalletResponse;
use Bagene\PhPayments\Tests\Factories\MayaTestFactory;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\PHPUnit\TestCase;

class MayaCreateWalletResponseTest extends TestCase
{
    public function testCreateWalletResponse(): void
    {
        $response = new Response(200, [], MayaTestFactory::WALLET_RESPONSE);
        $mayaCreateWalletResponse = new MayaCreateWalletResponse($response);

        $this->assertInstanceOf(MayaCreateWalletResponse::class, $mayaCreateWalletResponse);
        $this->assertEquals('payment-id', $mayaCreateWalletResponse->getPaymentId());
        $this->assertEquals('https://sandbox.maya.com.mm/wallet/payment-id', $mayaCreateWalletResponse->getRedirectUrl());
    }
}

<?php

namespace Bagene\PhPayments\Tests\Unit\Maya\Models;

use Bagene\PhPayments\Maya\Models\MayaCreateCheckoutResponse;
use Bagene\PhPayments\Maya\Models\MayaCreatePaymentResponse;
use Bagene\PhPayments\Maya\Models\MayaCreateTokenResponse;
use Bagene\PhPayments\Maya\Models\MayaCreateWalletResponse;
use Bagene\PhPayments\Tests\Factories\MayaTestFactory;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\PHPUnit\TestCase;

class MayaResponseTest extends TestCase
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

    public function testCreateWalletResponse(): void
    {
        $response = new Response(200, [], MayaTestFactory::WALLET_RESPONSE);
        $mayaCreateWalletResponse = new MayaCreateWalletResponse($response);

        $this->assertInstanceOf(MayaCreateWalletResponse::class, $mayaCreateWalletResponse);
        $this->assertEquals('payment-id', $mayaCreateWalletResponse->getPaymentId());
        $this->assertEquals('https://sandbox.maya.com.mm/wallet/payment-id', $mayaCreateWalletResponse->getRedirectUrl());
    }

    public function testCreateTokenResponse(): void
    {
        $response = new Response(200, [], MayaTestFactory::TOKEN_RESPONSE);
        $mayaCreateTokenResponse = new MayaCreateTokenResponse($response);

        $this->assertInstanceOf(MayaCreateTokenResponse::class, $mayaCreateTokenResponse);
        $this->assertEquals('0zjacza65HEobriYGN9g5XwaWZYVSeErdNnaNCLCo8QvUXuGg49KPJSy1XbhHPL8OisYOiYPJSQ2BxqR2AuC682Yu5G5LzrU0SK6ByWi0TyhkekWf1ssl6cMBWAVAOdArLcY1QXEyHdr8EsRAS2bHeMEpUU6OSmxmky5Fk', $mayaCreateTokenResponse->getPaymentTokenId());
        $this->assertEquals('AVAILABLE', $mayaCreateTokenResponse->getState());
        $this->assertEquals('2021-07-12T08:18:20.000Z', $mayaCreateTokenResponse->getCreatedAt());
        $this->assertEquals('2021-07-12T08:18:20.000Z', $mayaCreateTokenResponse->getUpdatedAt());
        $this->assertEquals('Others', $mayaCreateTokenResponse->getIssuer());
    }

    public function testCreatePaymentResponse(): void
    {
        $response = new Response(200, [], MayaTestFactory::PAYMENT_RESPONSE);
        $mayaCreatePaymentResponse = new MayaCreatePaymentResponse($response);

        $this->assertInstanceOf(MayaCreatePaymentResponse::class, $mayaCreatePaymentResponse);
        $this->assertEquals('7ea1f6ef-035c-4fcd-85e0-037c8d9d4a2c', $mayaCreatePaymentResponse->getId());
        $this->assertEquals(false, $mayaCreatePaymentResponse->getIsPaid());
        $this->assertEquals('FOR_AUTHENTICATION', $mayaCreatePaymentResponse->getStatus());
        $this->assertEquals('100', $mayaCreatePaymentResponse->getAmount());
        $this->assertEquals('PHP', $mayaCreatePaymentResponse->getCurrency());
        $this->assertEquals(false, $mayaCreatePaymentResponse->getCanVoid());
        $this->assertEquals(false, $mayaCreatePaymentResponse->getCanRefund());
        $this->assertEquals(false, $mayaCreatePaymentResponse->getCanCapture());
        $this->assertEquals('Charge for maya.juan@mail.com', $mayaCreatePaymentResponse->getDescription());
        $this->assertEquals('0zjacza65HEobriYGN9g5XwaWZYVSeErdNnaNCLCo8QvUXuGg49KPJSy1XbhHPL8OisYOiYPJSQ2BxqR2AuC682Yu5G5LzrU0SK6ByWi0TyhkekWf1ssl6cMBWAVAOdArLcY1QXEyHdr8EsRAS2bHeMEpUU6OSmxmky5Fk', $mayaCreatePaymentResponse->getPaymentTokenId());
        $this->assertEquals('1626084179', $mayaCreatePaymentResponse->getRequestReferenceNumber());
        $this->assertEquals('https://payments-web-sandbox.paymaya.com/authenticate?id=7ea1f6ef-035c-4fcd-85e0-037c8d9d4a2c', $mayaCreatePaymentResponse->getVerificationUrl());
        $this->assertEquals('1626084179', $mayaCreatePaymentResponse->getRequestReferenceNumber());
        $this->assertNull( $mayaCreatePaymentResponse->getFundSource());
        $this->assertNull($mayaCreatePaymentResponse->getBatchNumber());
        $this->assertNull($mayaCreatePaymentResponse->getTraceNumber());
        $this->assertNull($mayaCreatePaymentResponse->getEmvIccData());
        $this->assertNull($mayaCreatePaymentResponse->getReceipt());
        $this->assertNull($mayaCreatePaymentResponse->getApprovalCode());
        $this->assertNull($mayaCreatePaymentResponse->getReceiptNumber());
        $this->assertNull($mayaCreatePaymentResponse->getAuthorizationType());
        $this->assertNull($mayaCreatePaymentResponse->getCapturedAmount());
        $this->assertNull($mayaCreatePaymentResponse->getAuthorizationPayment());
        $this->assertNull($mayaCreatePaymentResponse->getCapturedPaymentId());
        $this->assertNull($mayaCreatePaymentResponse->getSubscription());
        $this->assertNull($mayaCreatePaymentResponse->getMetadata());
    }
}

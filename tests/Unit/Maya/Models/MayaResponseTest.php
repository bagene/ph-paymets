<?php

namespace Bagene\PhPayments\Tests\Unit\Maya\Models;

use Bagene\PhPayments\Maya\Models\MayaCreateCheckoutResponse;
use Bagene\PhPayments\Maya\Models\MayaCreatePaymentResponse;
use Bagene\PhPayments\Maya\Models\MayaCreateTokenResponse;
use Bagene\PhPayments\Maya\Models\MayaCreateWalletResponse;
use Bagene\PhPayments\Maya\Models\MayaCustomerResponse;
use Bagene\PhPayments\Maya\Models\ModelObjects\Address;
use Bagene\PhPayments\Maya\Models\ModelObjects\Contact;
use Bagene\PhPayments\Maya\Models\ModelObjects\ShippingAddress;
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

    public function testCustomerResponse(): void
    {
        $response = new Response(200, [], MayaTestFactory::CUSTOMER_RESPONSE);
        $mayaCustomerResponse = new MayaCustomerResponse($response);

        $this->assertEquals(json_decode(MayaTestFactory::CUSTOMER_RESPONSE, true), $mayaCustomerResponse->toArray());

        $this->assertInstanceOf(MayaCustomerResponse::class, $mayaCustomerResponse);
        $this->assertEquals('d29f1635-8313-4ed4-94e5-94b6a6018f52', $mayaCustomerResponse->getId());
        $this->assertEquals('Maya', $mayaCustomerResponse->getFirstName());
        $this->assertEquals('Jose', $mayaCustomerResponse->getMiddleName());
        $this->assertEquals('Juan', $mayaCustomerResponse->getLastName());
        $this->assertInstanceOf(Contact::class, $mayaCustomerResponse->getContact());
        $this->assertEquals('+63(2)1234567890', $mayaCustomerResponse->getContact()->getPhone());
        $this->assertEquals('maya.juan@mail.com', $mayaCustomerResponse->getContact()->getEmail());
        $this->assertInstanceOf(Address::class, $mayaCustomerResponse->getBillingAddress());
        $this->assertEquals('6F Launchpad', $mayaCustomerResponse->getBillingAddress()->getLine1());
        $this->assertEquals('Sheridan Street', $mayaCustomerResponse->getBillingAddress()->getLine2());
        $this->assertEquals('Mandaluyong City', $mayaCustomerResponse->getBillingAddress()->getCity());
        $this->assertEquals('Metro Manila', $mayaCustomerResponse->getBillingAddress()->getState());
        $this->assertEquals('1552', $mayaCustomerResponse->getBillingAddress()->getZipCode());
        $this->assertEquals('PH', $mayaCustomerResponse->getBillingAddress()->getCountryCode());
        $this->assertInstanceOf(ShippingAddress::class, $mayaCustomerResponse->getShippingAddress());
        $this->assertEquals('6F Launchpad', $mayaCustomerResponse->getShippingAddress()->getLine1());
        $this->assertEquals('Sheridan Street', $mayaCustomerResponse->getShippingAddress()->getLine2());
        $this->assertEquals('Mandaluyong City', $mayaCustomerResponse->getShippingAddress()->getCity());
        $this->assertEquals('Metro Manila', $mayaCustomerResponse->getShippingAddress()->getState());
        $this->assertEquals('1552', $mayaCustomerResponse->getShippingAddress()->getZipCode());
        $this->assertEquals('PH', $mayaCustomerResponse->getShippingAddress()->getCountryCode());
        $this->assertEquals('+63(2)1234567890', $mayaCustomerResponse->getShippingAddress()->getPhone());
        $this->assertEquals('Maya', $mayaCustomerResponse->getShippingAddress()->getFirstName());
        $this->assertEquals('Jose', $mayaCustomerResponse->getShippingAddress()->getMiddleName());
        $this->assertEquals('Juan', $mayaCustomerResponse->getShippingAddress()->getLastName());
        $this->assertEquals('maya.juan@mail.com', $mayaCustomerResponse->getShippingAddress()->getEmail());
        $this->assertEquals('ST', $mayaCustomerResponse->getShippingAddress()->getShippingType());
        $this->assertEquals('F', $mayaCustomerResponse->getSex());
        $this->assertEquals('1987-07-28', $mayaCustomerResponse->getBirthday());
        $this->assertEquals('2020-12-25', $mayaCustomerResponse->getCustomerSince());
        $this->assertEquals('2021-07-06T14:01:25.000Z', $mayaCustomerResponse->getCreatedAt());
        $this->assertEquals('2021-07-06T14:01:25.000Z', $mayaCustomerResponse->getUpdatedAt());
    }
}

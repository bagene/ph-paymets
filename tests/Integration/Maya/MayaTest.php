<?php

namespace Bagene\PhPayments\Tests\Integration\Maya;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Helpers\PaymentBuilder;
use Bagene\PhPayments\Maya\Models\MayaCreateCheckoutResponse;
use Bagene\PhPayments\Maya\Models\MayaCreatePaymentResponse;
use Bagene\PhPayments\Maya\Models\MayaCreateTokenResponse;
use Bagene\PhPayments\Maya\Models\MayaCreateWalletResponse;
use Bagene\PhPayments\Tests\Factories\MayaTestFactory;
use Bagene\PhPayments\Tests\ShouldMock;
use Bagene\PhPayments\Tests\TestCase;

final class MayaTest extends TestCase
{
    use ShouldMock;

    public function testCreateCheckout(): void
    {
        $this->mockResponse(MayaTestFactory::CHECKOUT_RESPONSE);
        $response = PaymentBuilder::maya()
            ->checkout()
            ->create([
                'totalAmount' => 10000,
                'requestReferenceNumber' => 'requestReferenceNumber',
            ]);

        $this->assertInstanceOf(MayaCreateCheckoutResponse::class, $response);
        $this->assertEquals('checkout-id', $response->getCheckoutId());
        $this->assertEquals('https://sandbox.maya.com.mm/checkout/checkout-id', $response->getRedirectUrl());
    }

    /**
     * @dataProvider providerCheckoutErrors
     * @param array<string, string|float>|array{} $data
     */
    public function testCreateCheckoutExpectsException(array $data, string $error): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage($error);
        PaymentBuilder::maya()
            ->checkout()
            ->create($data);
    }

    /** @return array<string, array{0: array<string, string|numeric>, 1: string}> */
    public static function providerCheckoutErrors(): array
    {
        return [
            'empty' => [
                [],
                'Missing required fields: totalAmount, requestReferenceNumber',
            ],
            'totalAmount is required' => [
                [
                    'requestReferenceNumber' => 'requestReferenceNumber',
                ],
                'Missing required fields: totalAmount',
            ],
            'requestReferenceNumber is required' => [
                [
                    'totalAmount' => 10000,
                ],
                'Missing required fields: requestReferenceNumber',
            ],
        ];
    }

    public function testCreateWallet(): void
    {
        $this->mockResponse(MayaTestFactory::WALLET_RESPONSE);
        $response = PaymentBuilder::maya()
            ->wallet()
            ->create([
                'totalAmount' => 10000,
                'requestReferenceNumber' => 'requestReferenceNumber',
                'redirectUrl' => 'https://example.org/redirect-url',
            ]);

        $this->assertInstanceOf(MayaCreateWalletResponse::class, $response);
        $this->assertEquals('payment-id', $response->getPaymentId());
        $this->assertEquals('https://sandbox.maya.com.mm/wallet/payment-id', $response->getRedirectUrl());
    }

    public function testCreateToken(): void
    {
        $this->mockResponse(MayaTestFactory::TOKEN_RESPONSE);
        $response = PaymentBuilder::maya()
            ->token()
            ->create([
                'card' => [
                    'number' => '4111111111111111',
                    'expMonth' => '12',
                    'expYear' => '2023',
                    'cvc' => '123',
                ],
            ]);

        $this->assertInstanceOf(MayaCreateTokenResponse::class, $response);
        $this->assertEquals('0zjacza65HEobriYGN9g5XwaWZYVSeErdNnaNCLCo8QvUXuGg49KPJSy1XbhHPL8OisYOiYPJSQ2BxqR2AuC682Yu5G5LzrU0SK6ByWi0TyhkekWf1ssl6cMBWAVAOdArLcY1QXEyHdr8EsRAS2bHeMEpUU6OSmxmky5Fk', $response->getPaymentTokenId());
        $this->assertEquals('AVAILABLE', $response->getState());
        $this->assertEquals('2021-07-12T08:18:20.000Z', $response->getCreatedAt());
        $this->assertEquals('2021-07-12T08:18:20.000Z', $response->getUpdatedAt());
        $this->assertEquals('Others', $response->getIssuer());
    }

    /**
     * @dataProvider providerTokenErrors
     * @param array<string, string|float> $data
     */
    public function testCreateTokenExpectsException(array $data, string $error): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage($error);
        PaymentBuilder::maya()
            ->token()
            ->create($data);
    }

    /** @return array<string, array{
     *     0: array<string, array<string, string>>,
     *     1: string
     * }>
     */
    public static function providerTokenErrors(): array
    {
        return [
            'empty' => [
                [
                    'card' => [],
                ],
                'Missing required fields: card.number, card.expMonth, card.expYear, card.cvc',
            ],
            'card.number is required' => [
                [
                    'card' => [
                        'expMonth' => '12',
                        'expYear' => '2023',
                        'cvc' => '123',
                    ],
                ],
                'Missing required fields: card.number',
            ],
            'card.expMonth is required' => [
                [
                    'card' => [
                        'number' => '4111111111111111',
                        'expYear' => '2023',
                        'cvc' => '123',
                    ],
                ],
                'Missing required fields: card.expMonth',
            ],
            'card.expYear is required' => [
                [
                    'card' => [
                        'number' => '4111111111111111',
                        'expMonth' => '12',
                        'cvc' => '123',
                    ],
                ],
                'Missing required fields: card.expYear',
            ],
            'card.cvc is required' => [
                [
                    'card' => [
                        'number' => '4111111111111111',
                        'expMonth' => '12',
                        'expYear' => '2023',
                    ],
                ],
                'Missing required fields: card.cvc',
            ],
        ];
    }

    public function testCreatePayment(): void
    {
        $this->mockResponse(MayaTestFactory::PAYMENT_RESPONSE);

        /** @var MayaCreatePaymentResponse $response */
        $response = PaymentBuilder::maya()
            ->payment()
            ->create([
                'totalAmount' => [
                    'amount' => 100,
                    'currency' => 'PHP',
                ],
                'requestReferenceNumber' => 'requestReferenceNumber',
                'paymentTokenId' => 'paymentTokenId',
            ]);

        $this->assertInstanceOf(MayaCreatePaymentResponse::class, $response);
        $this->assertEquals('7ea1f6ef-035c-4fcd-85e0-037c8d9d4a2c', $response->getId());
        $this->assertEquals(false, $response->getIsPaid());
        $this->assertEquals('FOR_AUTHENTICATION', $response->getStatus());
        $this->assertEquals(100, $response->getAmount());
        $this->assertEquals('PHP', $response->getCurrency());
        $this->assertEquals(false, $response->getCanVoid());
        $this->assertEquals(false, $response->getCanRefund());
        $this->assertEquals(false, $response->getCanCapture());
        $this->assertEquals('2021-07-12T10:02:55.000Z', $response->getCreatedAt());
        $this->assertEquals('2021-07-12T10:02:55.000Z', $response->getUpdatedAt());
        $this->assertEquals('1626084179', $response->getRequestReferenceNumber());
    }

    public function testCreatePaymentWithCard(): void
    {
        $this->mockResponse([
            MayaTestFactory::TOKEN_RESPONSE,
            MayaTestFactory::PAYMENT_RESPONSE,
        ]);

        $response = PaymentBuilder::maya()
            ->payment()
            ->create([
                'totalAmount' => [
                    'amount' => 100,
                    'currency' => 'PHP',
                ],
                'requestReferenceNumber' => 'requestReferenceNumber',
                'card' => [
                    'number' => '4111111111111111',
                    'expMonth' => '12',
                    'expYear' => '2023',
                    'cvc' => '123',
                ],
            ]);

        $this->assertInstanceOf(MayaCreatePaymentResponse::class, $response);
        $this->assertEquals('7ea1f6ef-035c-4fcd-85e0-037c8d9d4a2c', $response->getId());
        $this->assertEquals(false, $response->getIsPaid());
        $this->assertEquals('FOR_AUTHENTICATION', $response->getStatus());
        $this->assertEquals(100, $response->getAmount());
        $this->assertEquals('PHP', $response->getCurrency());
        $this->assertEquals(false, $response->getCanVoid());
        $this->assertEquals(false, $response->getCanRefund());
        $this->assertEquals(false, $response->getCanCapture());
        $this->assertEquals('2021-07-12T10:02:55.000Z', $response->getCreatedAt());
        $this->assertEquals('2021-07-12T10:02:55.000Z', $response->getUpdatedAt());
    }
}

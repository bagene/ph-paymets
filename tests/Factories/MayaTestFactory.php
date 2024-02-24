<?php

namespace Bagene\PhPayments\Tests\Factories;

final class MayaTestFactory
{
    public const CHECKOUT_RESPONSE = '{
        "checkoutId": "checkout-id",
        "redirectUrl": "https://sandbox.maya.com.mm/checkout/checkout-id"
    }';

    public const WALLET_RESPONSE = '{
        "paymentId": "payment-id",
        "redirectUrl": "https://sandbox.maya.com.mm/wallet/payment-id"
    }';

    public const TOKEN_RESPONSE = '{
        "paymentTokenId": "0zjacza65HEobriYGN9g5XwaWZYVSeErdNnaNCLCo8QvUXuGg49KPJSy1XbhHPL8OisYOiYPJSQ2BxqR2AuC682Yu5G5LzrU0SK6ByWi0TyhkekWf1ssl6cMBWAVAOdArLcY1QXEyHdr8EsRAS2bHeMEpUU6OSmxmky5Fk",
        "state": "AVAILABLE",
        "createdAt": "2021-07-12T08:18:20.000Z",
        "updatedAt": "2021-07-12T08:18:20.000Z",
        "issuer": "Others"
    }';

    public const PAYMENT_RESPONSE = '{
        "id": "7ea1f6ef-035c-4fcd-85e0-037c8d9d4a2c",
        "isPaid": false,
        "status": "FOR_AUTHENTICATION",
        "amount": "100",
        "currency": "PHP",
        "canVoid": false,
        "canRefund": false,
        "canCapture": false,
        "createdAt": "2021-07-12T10:02:55.000Z",
        "updatedAt": "2021-07-12T10:02:55.000Z",
        "description": "Charge for maya.juan@mail.com",
        "paymentTokenId": "0zjacza65HEobriYGN9g5XwaWZYVSeErdNnaNCLCo8QvUXuGg49KPJSy1XbhHPL8OisYOiYPJSQ2BxqR2AuC682Yu5G5LzrU0SK6ByWi0TyhkekWf1ssl6cMBWAVAOdArLcY1QXEyHdr8EsRAS2bHeMEpUU6OSmxmky5Fk",
        "requestReferenceNumber": "1626084179",
        "verificationUrl": "https://payments-web-sandbox.paymaya.com/authenticate?id=7ea1f6ef-035c-4fcd-85e0-037c8d9d4a2c"
    }';
}

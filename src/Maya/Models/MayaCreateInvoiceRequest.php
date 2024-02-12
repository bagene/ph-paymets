<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Requests\Request;
use GuzzleHttp\Exception\GuzzleException;

class MayaCreateInvoiceRequest extends Request implements MayaRequestInterface
{
    public function setDefaults(): void
    {
        // TODO: Implement setDefaults() method.
    }

    public function getEndpoint(): string
    {
        $host = static::PRODUCTION_BASE_URL;
        if (config('payments.maya.use_sandbox')) {
            $host = static::SANDBOX_BASE_URL;
        }

        if (config('payments.maya.mode', 'card') === 'wallet') {
            return $host . static::WALLET_PAYMENT_ENDPOINT;
        }

        return $host . static::CHECKOUT_ENDPOINT;
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return MayaInvoiceResponse
     * @throws RequestException
     * @throws GuzzleException
     */
    public function send(): MayaInvoiceResponse
    {
        // TODO: Validate the request body

        $response = parent::sendRequest(); // TODO: Change the autogenerated stub

        if (config('payments.maya.mode', 'card') === 'wallet') {
            return new MayaWalletPaymentResponse($response);
        } else {
            return new MayaCheckoutResponse($response);
        }
    }
}

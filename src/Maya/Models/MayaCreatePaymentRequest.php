<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Exceptions\RequestException;
use Bagene\PhPayments\Helpers\HostResolver;
use Bagene\PhPayments\Requests\Request;
use Bagene\PhPayments\Traits\HasExtraRequest;

class MayaCreatePaymentRequest extends Request implements MayaRequest
{
    use HasExtraRequest;
    /**
     * @return void
     */
    function setDefaults(): void
    {
        // TODO: Implement setDefaults() method.
    }

    /**
     * @return string
     */
    function getEndpoint(): string
    {
        return HostResolver::resolve(
            'Maya',
            boolval(config('payments.maya.use_sandbox'))
        ) . self::PAYMENT_ENDPOINT;
    }

    /**
     * @return string
     */
    function getMethod(): string
    {
        return 'POST';
    }

    /**
     * @return string[]
     */
    protected function getRequiredFields(): array
    {
        return [
            'paymentTokenId',
            'totalAmount.amount',
            'totalAmount.currency',
        ];
    }

    /** @throws RequestException */
    protected function extraRequest(): void
    {
        if (array_key_exists('card', $this->body)) {
            /** @var MayaCreateTokenResponse $response */
            $response = $this->request(MayaCreateTokenRequest::class);

            $this->body['paymentTokenId'] = $response->getPaymentTokenId();
        }
    }
}

<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Helpers\HostResolver;
use Bagene\PhPayments\Requests\Request;

final class MayaCreateCheckoutRequest extends Request implements MayaRequest
{
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
        ) . self::CHECKOUT_ENDPOINT;
    }

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
            'totalAmount',
            'requestReferenceNumber',
        ];
    }
}

<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Helpers\HostResolver;
use Bagene\PhPayments\Requests\Request;

class MayaCreateTokenRequest extends Request implements MayaRequest
{
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
        ) . self::TOKEN_ENDPOINT;
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
            'card.number',
            'card.expMonth',
            'card.expYear',
            'card.cvc',
        ];
    }
}

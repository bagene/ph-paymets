<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Helpers\HostResolver;
use Bagene\PhPayments\Requests\Request;

class MayaCreateCustomerRequest extends Request implements MayaRequest
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
        ) . self::CUSTOMER_ENDPOINT;
    }

    /**
     * @return string
     */
    function getMethod(): string
    {
        return 'POST';
    }

    protected function getRequiredFields(): array
    {
        return config('payments.maya.kount_enabled')
            ? $this->getRequiredKountFields()
            : $this->getRequiredBasicFields();
    }

    /**
     * @return string[]
     */
    protected function getRequiredBasicFields(): array
    {
        return [
            'firstName',
            'middleName',
            'lastName',
            'contact.phone',
            'contact.email',
        ];
    }

    /**
     * @return string[]
     */
    protected function getRequiredKountFields(): array
    {
        return [
            'firstName',
            'lastName',
            'contact.phone',
            'contact.email',
            'billingAddress.countryCode',
            'shippingAddress.countryCode',
        ];
    }
}

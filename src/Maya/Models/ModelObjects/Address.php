<?php

namespace Bagene\PhPayments\Maya\Models\ModelObjects;

use Bagene\PhPayments\Requests\AbstractModel;

class Address extends AbstractModel
{
    public function __construct(
        protected string $line1,
        protected string $line2,
        protected string $city,
        protected string $state,
        protected string $zipCode,
        protected string $countryCode
    ) {
    }

    public function getLine1(): string
    {
        return $this->line1;
    }

    public function getLine2(): string
    {
        return $this->line2;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}

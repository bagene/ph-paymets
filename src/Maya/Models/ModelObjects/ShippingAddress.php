<?php

namespace Bagene\PhPayments\Maya\Models\ModelObjects;

class ShippingAddress extends Address
{
    public function __construct(
        protected string $line1,
        protected string $line2,
        protected string $city,
        protected string $state,
        protected string $zipCode,
        protected string $countryCode,
        protected string $firstName,
        protected string $middleName,
        protected string $lastName,
        protected string $phone,
        protected string $email,
        protected string $shippingType,
    ) {
        parent::__construct($line1, $line2, $city, $state, $zipCode, $countryCode);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getShippingType(): string
    {
        return $this->shippingType;
    }
}

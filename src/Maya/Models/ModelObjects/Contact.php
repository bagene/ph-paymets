<?php

namespace Bagene\PhPayments\Maya\Models\ModelObjects;

use Bagene\PhPayments\Requests\AbstractModel;

final class Contact extends AbstractModel
{
    public function __construct(
        protected string $phone,
        protected string $email
    ) {
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

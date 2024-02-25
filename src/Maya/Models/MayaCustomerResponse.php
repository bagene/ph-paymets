<?php

namespace Bagene\PhPayments\Maya\Models;

use Bagene\PhPayments\Maya\Models\ModelObjects\Address;
use Bagene\PhPayments\Maya\Models\ModelObjects\Contact;
use Bagene\PhPayments\Maya\Models\ModelObjects\ShippingAddress;
use Bagene\PhPayments\Requests\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MayaCustomerResponse
 * @property-read array{
 *     id: string,
 *     firstName: string,
 *     middleName: string,
 *     lastName: string,
 *     contact: array{phone: string, email: string},
 *     billingAddress: array{line1: string, line2: string, city: string, state: string, zipCode: string, countryCode: string},
 *     shippingAddress: array{
 *      line1: string,
 *      line2: string,
 *      city: string,
 *      state: string,
 *      zipCode: string,
 *      countryCode: string,
 *      firstName: string,
 *      middleName: string,
 *      lastName: string,
 *      phone: string,
 *      email: string,
 *      shippingType: string
 *    },
 *    sex: string,
 *    birthday: string,
 *    customerSince: string,
 *    createdAt: string,
 *    updatedAt: string
 * } $body
 */
class MayaCustomerResponse extends Response
{
    protected string $id;
    protected string $firstName;
    protected string $middleName;
    protected string $lastName;
    protected Contact $contact;
    protected Address $billingAddress;
    protected ShippingAddress $shippingAddress;
    protected string $sex;
    protected string $birthday;
    protected string $customerSince;
    protected string $createdAt;
    protected string $updatedAt;

    protected function setResponse(ResponseInterface $response): void
    {
        parent::setResponse($response);

        $this->id = $this->body['id'];
        $this->firstName = $this->body['firstName'];
        $this->middleName = $this->body['middleName'];
        $this->lastName = $this->body['lastName'];
        $this->contact = new Contact(
            ...array_values($this->body['contact'])
        );
        $this->billingAddress = new Address(
            ...$this->body['billingAddress']
        );
        $this->shippingAddress = new ShippingAddress(
            ...$this->body['shippingAddress']
        );
        $this->sex = $this->body['sex'];
        $this->birthday = $this->body['birthday'];
        $this->customerSince = $this->body['customerSince'];
        $this->createdAt = $this->body['createdAt'];
        $this->updatedAt = $this->body['updatedAt'];
    }

    public function getId(): string
    {
        return $this->id;
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

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getBillingAddress(): Address
    {
        return $this->billingAddress;
    }

    public function getShippingAddress(): ShippingAddress
    {
        return $this->shippingAddress;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getCustomerSince(): string
    {
        return $this->customerSince;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}

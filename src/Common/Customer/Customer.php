<?php

namespace Omnibill\Common\Customer;

use Omnibill\Common\Helper;
use Omnibill\Common\ParametersTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

class Customer implements CustomerInterface
{
    use ParametersTrait;

    public function __construct(array $parameters = null)
    {
        $this->initialize($parameters);
    }

    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag;

        Helper::initialize($this, $parameters);

        return $this;
    }

    public function getName(): string
    {
        return $this->getParameter('name');
    }

    public function setName(string $value): Customer
    {
        return $this->setParameter('name', $value);
    }

    public function getFirstName(): string
    {
        return $this->getParameter('firstName');
    }

    public function setFirstName(string $value): Customer
    {
        return $this->setParameter('firstName', $value);
    }

    public function getLastName(): string
    {
        return $this->getParameter('lastName');
    }

    public function setLastName(string $value): Customer
    {
        return $this->setParameter('lastName', $value);
    }

    public function getEmail(): string
    {
        return $this->getParameter('email');
    }

    public function setEmail(string $value): Customer
    {
        return $this->setParameter('email', $value);
    }

    public function getAddress(): string
    {
        return $this->getParameter('address');
    }

    public function setAddress(string $value): Customer
    {
        return $this->setParameter('address', $value);
    }

    public function getPostcode(): string
    {
        return $this->getParameter('postcode');
    }

    public function setPostcode(string $value): Customer
    {
        return $this->setParameter('postcode', $value);
    }

    public function getPhone(): string
    {
        return $this->getParameter('phone');
    }

    public function setPhone(string $value): Customer
    {
        return $this->setParameter('phone', $value);
    }

    public function getCity(): string
    {
        return $this->getParameter('city');
    }

    public function setCity(string $value): Customer
    {
        return $this->setParameter('city', $value);
    }

    public function getVatId(): ?string
    {
        return $this->getParameter('vat_id');
    }

    public function setVatId(?string $value): Customer
    {
        return $this->setParameter('vat_id', $value);
    }

    public function getCompanyName(): ?string
    {
        return $this->getParameter('company_name');
    }

    public function setCompanyName(?string $value): Customer
    {
        return $this->setParameter('company_name', $value);
    }

    public function getCountry(): string
    {
        return $this->getParameter('country');
    }

    public function setCountry(string $value): Customer
    {
        return $this->setParameter('country', $value);
    }
}
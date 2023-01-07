<?php

namespace Omnibill\ifirma;

trait HasIfirmaCredentials
{
    public function getLogin(): string
    {
        return $this->getParameter('login');
    }

    public function setLogin(string $value): static
    {
        return $this->setParameter('login', $value);
    }

    public function getInvoiceKey(): string
    {
        return $this->getParameter('invoiceKey');
    }

    public function setInvoiceKey(string $value): static
    {
        return $this->setParameter('invoiceKey', $value);
    }

    public function getSubscriberKey(): string
    {
        return $this->getParameter('subscriberKey');
    }

    public function setSubscriberKey(string $value): static
    {
        return $this->setParameter('subscriberKey', $value);
    }
}
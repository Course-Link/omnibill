<?php

namespace Omnibill\ifirma;

use Omnibill\Common\AbstractGateway;
use Omnibill\Common\Message\AbstractRequest;
use Omnibill\ifirma\Messages\CreateInvoiceRequest;
use Omnibill\ifirma\Messages\SendInvoiceRequest;

class Gateway extends AbstractGateway
{
    use HasIfirmaCredentials;

    public function getName(): string
    {
        return 'ifirma';
    }

    public function createInvoice(array $options = []): AbstractRequest
    {
        return $this->createRequest(CreateInvoiceRequest::class, $options);
    }

    public function sendInvoice(array $options = []): AbstractRequest
    {
        return $this->createRequest(SendInvoiceRequest::class, $options);
    }
}
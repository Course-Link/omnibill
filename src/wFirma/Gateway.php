<?php

namespace Omnibill\wFirma;

use Omnibill\Common\AbstractGateway;
use Omnibill\Common\Message\AbstractRequest;
use Omnibill\wFirma\Messages\CreateInvoiceRequest;
use Omnibill\wFirma\Messages\SendInvoiceRequest;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'wFirma';
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
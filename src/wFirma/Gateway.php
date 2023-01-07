<?php

namespace Omnibill\wFirma;

use Omnibill\Common\AbstractGateway;
use Omnibill\Common\Message\AbstractRequest;
use Omnibill\wFirma\Messages\CreateInvoiceRequest;

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
}
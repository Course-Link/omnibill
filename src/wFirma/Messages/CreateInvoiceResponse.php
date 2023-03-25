<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Message\AbstractResponse;

class CreateInvoiceResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return isset($this->data['invoices'][0]['invoice']['id']);
    }

    public function getInvoiceId()
    {
        return $this->data['invoices'][0]['invoice']['id'];
    }
}
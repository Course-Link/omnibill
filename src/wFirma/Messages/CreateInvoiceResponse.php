<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Message\AbstractResponse;

class CreateInvoiceResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return isset($this->data['invoices'][0]['invoice']['id']);
    }

    public function getInvoiceReference(): ?string
    {
        return $this->data['invoices'][0]['invoice']['id'] ?? null;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->data['invoices'][0]['invoice']['fullnumber'] ?? null;
    }

    public function isInvoiceSent(): bool
    {
        return ($this->data['invoices'][0]['invoice']['auto_send'] ?? false) === "1";
    }
}
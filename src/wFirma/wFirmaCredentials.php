<?php

namespace Omnibill\wFirma;

use Omnibill\Common\OAuth\HasOAuth2Token;

trait wFirmaCredentials
{
    use HasOAuth2Token;

    public function getCompanyId(): string
    {
        return $this->getParameter('companyId');
    }

    public function setCompanyId(string $value): self
    {
        return $this->setParameter('companyId', $value);
    }
}
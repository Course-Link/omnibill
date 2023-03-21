<?php

namespace Omnibill\wFirma;

use Omnibill\Common\OAuth\AbstractOAuth2Connector;

class Connector extends AbstractOAuth2Connector
{
    protected function getAuthUrl(string $state): string
    {
        return $this->buildAuthUrlFromBase(
            'https://wfirma.pl/oauth2/auth',
            $state
        );
    }

    protected function getTokenUrl(): string
    {
        return 'https://api2.wfirma.pl/oauth2/token?oauth_version=2';
    }
}
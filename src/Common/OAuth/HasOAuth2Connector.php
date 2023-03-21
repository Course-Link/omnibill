<?php

namespace Omnibill\Common\OAuth;

trait HasOAuth2Connector
{
    protected function buildOAuth2Connector(string $provider): AbstractOAuth2Connector
    {
        return new $provider(
            $this->httpClient,
            $this->httpRequest,
            $this->getClientId(),
            $this->getClientSecret(),
            $this->getRedirectUrl(),
        );
    }
}
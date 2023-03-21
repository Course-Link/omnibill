<?php

namespace Omnibill\Common\OAuth;

interface OAuth2GatewayInterface
{
    public function getConnector(): AbstractOAuth2Connector;
}
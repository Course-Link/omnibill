<?php

namespace Omnibill\wFirma;

use Omnibill\Common\AbstractGateway;
use Omnibill\Common\Exception\AuthException;
use Omnibill\Common\Message\AbstractRequest;
use Omnibill\Common\OAuth\AbstractOAuth2Connector;
use Omnibill\Common\OAuth\HasOAuth2Connector;
use Omnibill\Common\OAuth\OAuth2GatewayInterface;
use Omnibill\wFirma\Messages\CreateInvoiceRequest;
use Omnibill\wFirma\Messages\RefreshTokenRequest;
use Omnibill\wFirma\Messages\SendInvoiceRequest;

class Gateway extends AbstractGateway implements OAuth2GatewayInterface
{
    use HasOAuth2Connector;
    use wFirmaCredentials;

    public function getName(): string
    {
        return 'wFirma';
    }

    public function getConnector(): AbstractOAuth2Connector
    {
        return $this->buildOAuth2Connector(Connector::class);
    }

    public function refreshToken(array $options = []): AbstractRequest
    {
        return $this->createRequest(RefreshTokenRequest::class, $options);
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
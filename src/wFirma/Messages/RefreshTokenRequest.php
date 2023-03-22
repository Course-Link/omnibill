<?php

namespace Omnibill\wFirma\Messages;

class RefreshTokenRequest extends AbstractRequest
{
    public function getData(): array
    {
        return [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->getRefreshToken(),
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
        ];
    }

    public function sendData($data): RefreshTokenResponse
    {
        $endpoint = self::$host . 'oauth2/token?oauth_version=2';

        $httpResponse = $this->httpClient->request(
            'post',
            $endpoint,
            [],
            json_encode($data)
        );

        $data = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new RefreshTokenResponse($this, $data);
    }
}
<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Message\AbstractResponse;

class RefreshTokenResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return isset($this->data['access_token']) && isset($this->data['refresh_token']);
    }

    public function getData(): array
    {
        return [
            'access_token' => $this->data['access_token'],
            'expires_in' => $this->data['expires_in'] ?? null,
            'token_type' => $this->data['token_type'],
            'scope' => $this->data['scope'] ?? null,
            'refresh_token' => $this->data['refresh_token'],
        ];
    }
}
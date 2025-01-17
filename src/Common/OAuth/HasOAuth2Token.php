<?php

namespace Omnibill\Common\OAuth;

trait HasOAuth2Token
{
    public function getClientId(): string
    {
        return $this->getParameter('clientId');
    }

    public function setClientId(string $value): self
    {
        return $this->setParameter('clientId', $value);
    }

    public function getClientSecret(): string
    {
        return $this->getParameter('clientSecret');
    }

    public function setClientSecret(string $value): self
    {
        return $this->setParameter('clientSecret', $value);
    }

    public function getAccessToken(): ?string
    {
        return $this->getParameter('accessToken');
    }

    public function setAccessToken($value): self
    {
        return $this->setParameter('accessToken', $value);
    }

    public function getTokenExpires(): ?int
    {
        return $this->getParameter('tokenExpires');
    }

    public function setTokenExpires($value): self
    {
        return $this->setParameter('tokenExpires', $value);
    }

    public function getRefreshToken(): ?string
    {
        return $this->getParameter('refreshToken');
    }

    public function setRefreshToken($value): self
    {
        return $this->setParameter('refreshToken', $value);
    }

    public function getRedirectUrl(): ?string
    {
        return $this->getParameter('redirectUrl');
    }

    public function setRedirectUrl($value): self
    {
        return $this->setParameter('redirectUrl', $value);
    }

    public function hasToken(): bool
    {
        $token = $this->getParameter('token');

        $expires = $this->getTokenExpires();
        if (!empty($expires) && !is_numeric($expires)) {
            $expires = strtotime($expires);
        }

        return !empty($token) && time() < $expires;
    }

//    public function getToken(bool $createIfNeeded = true): string
//    {
//        if ($createIfNeeded && !$this->hasToken()) {
//            $response = $this->createToken()->send();
//            if ($response->isSuccessful()) {
//                $data = $response->getData();
//
//                if (isset($data['access_token'])) {
//                    $this->setToken($data['access_token']);
//                    $this->setTokenExpires(time() + $data['expires_in']);
//                }
//            }
//        }
//
//        return $this->getParameter('token');
//    }
}
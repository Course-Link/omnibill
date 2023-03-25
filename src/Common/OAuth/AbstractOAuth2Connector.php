<?php

namespace Omnibill\Common\OAuth;

use Omnibill\Common\Exception\RuntimeException;
use Omnibill\Common\Http\ClientInterface;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpRedirectResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

abstract class AbstractOAuth2Connector
{
    protected array $parameters = [];
    protected array $scopes = [];
    protected string $scopeSeparator = ',';
    protected int $encodingType = PHP_QUERY_RFC1738;
    protected bool $stateless = false;
    protected ?string $state = null;

    public function __construct(
        protected ClientInterface $httpClient,
        protected HttpRequest     $httpRequest,
        protected string          $clientId,
        protected string          $clientSecret,
        protected string          $redirectUrl,
    )
    {
    }

    public function isStateless(): bool
    {
        return $this->stateless;
    }

    abstract protected function getAuthUrl(string $state): string;

    abstract protected function getTokenUrl(): string;

    public function redirect(): HttpRedirectResponse|HttpResponse
    {
        if ($this->usesState() && $this->state === null) {
            $this->prepareState();
        }

        return new HttpRedirectResponse($this->getAuthUrl($this->state));
    }

    public function getData(): array
    {
        if ($this->hasInvalidState()) {
            throw new RuntimeException('Invalid State');
        }

        $response = $this->getAccessTokenResponse($this->getCode());

        $token = $response['access_token'] ?? null;
        $refreshToken = $response['refresh_token'] ?? null;
        $expires = $response['expires_in'] ?? null;
        $approvedScopes = explode($this->scopeSeparator, $response['scope'] ?? '');

        return [
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'expires' => $expires,
            'approved_scopes' => $approvedScopes,
        ];
    }

    public function getAccessTokenResponse(string $code): array
    {
        $response = $this->httpClient->request('POST',
            $this->getTokenUrl(),
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            http_build_query($this->getTokenFields($code))
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function buildAuthUrlFromBase($url, $state): string
    {
        return $url . '?' . http_build_query($this->getCodeFields($state), '', '&', $this->encodingType);
    }

    protected function getTokenFields(string $code): array
    {
        return [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $this->redirectUrl,
        ];
    }

    protected function getCodeFields($state = null): array
    {
        $fields = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'scope' => $this->formatScopes($this->getScopes(), $this->scopeSeparator),
            'response_type' => 'code',
        ];

        if ($this->usesState()) {
            $fields['state'] = $state;
        }

        return array_merge($fields, $this->parameters);
    }

    protected function formatScopes(array $scopes, $scopeSeparator): string
    {
        return implode($scopeSeparator, $scopes);
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    protected function usesState(): bool
    {
        return !$this->stateless;
    }

    public function prepareState(int $length = 40): static
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        $this->state = $string;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    private function hasInvalidState(): bool
    {
        if ($this->isStateless()) {
            return false;
        }

        $state = $this->httpRequest->getSession()->get('state');

        return empty($state) || $this->httpRequest->get('state') !== $state;
    }

    private function getCode(): string
    {
        return $this->httpRequest->get('code');
    }
}
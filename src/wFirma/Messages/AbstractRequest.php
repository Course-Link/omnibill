<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Exception\AuthException;
use Omnibill\Common\Message\AbstractRequest as BaseRequest;
use Omnibill\wFirma\wFirmaCredentials;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractRequest extends BaseRequest
{
    use wfirmaCredentials;

    protected static string $host = 'https://api2.wfirma.pl/';

    /**
     * @throws AuthException
     */
    protected function sendRequest(string $method, string $endpoint, array $data = null): array
    {
        $query = http_build_query([
            'input_format' => 'json',
            'output_format' => 'json',
            'oauth_version' => 2,
            'companyId' => $this->getCompanyId(),
        ]);

        $endpoint = self::$host . $endpoint . '?' . $query;

        $httpResponse = $this->httpClient->request(
            $method,
            $endpoint,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
            json_encode($data)
        );

        $status = $httpResponse->getStatusCode();

        if ($status === 401) {
            throw new AuthException('Invalid credentials');
        }

        return json_decode($httpResponse->getBody()->getContents(), true);
    }
}
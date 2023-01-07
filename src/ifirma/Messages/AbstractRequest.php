<?php

namespace Omnibill\ifirma\Messages;

use Omnibill\Common\Message\AbstractRequest as BaseRequest;
use Omnibill\ifirma\HasIfirmaCredentials;

abstract class AbstractRequest extends BaseRequest
{
    use HasIfirmaCredentials;

    protected static string $invoiceKeyName = 'faktura';
    protected static string $subscriberKeyName = 'abonent';

    protected static string $host = 'https://www.ifirma.pl/iapi/';


    protected function prepareKey(string $rawKey): string
    {
        $key = '';
        for ($i = 0; $i < strlen($rawKey); $i += 2) {
            $key .= chr(hexdec($rawKey[$i] . $rawKey[$i + 1]));
        }
        return $key;
    }

    protected function calculateSignature(
        string $url,
        string $keyName,
        string $key,
        ?array $data = null,
    ): string
    {
        $hash = $url . $this->getLogin() . $keyName;

        if ($data) {
            $hash .= json_encode($data);
        }

        return hash_hmac('sha1', $hash, $key);
    }
}
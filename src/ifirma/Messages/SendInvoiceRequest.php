<?php

namespace Omnibill\ifirma\Messages;

class SendInvoiceRequest extends AbstractRequest
{

    public function getData(): array
    {
        return [
            'Tekst' => 'Message'
        ];
    }

    public function sendData($data): SendInvoiceResponse
    {
        $url = self::$host . 'fakturakraj/send/' . $this->getTransactionReference() . '.json';
        $signature = $this->calculateSignature($url, self::$invoiceKeyName, $this->getInvoiceKey(), $data);

        $httpResponse = $this->httpClient->request(
            'post',
            $url,
            [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                'Charset' => 'UTF-8',
                'Authentication' => 'IAPIS user=' . $this->getLogin() . ', hmac-sha1=' . $signature,
            ],
            json_encode($data)
        );

        $data = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new SendInvoiceResponse($this, $data);
    }
}
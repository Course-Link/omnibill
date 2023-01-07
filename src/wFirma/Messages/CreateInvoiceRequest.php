<?php

namespace Omnibill\wFirma\Messages;

class CreateInvoiceRequest extends AbstractRequest
{
    public function getData(): array
    {
        return [
            'invoices' => [
                0 => [
                    'invoice' => [
                        'contractor' => [

                        ],
                        'type' => $this->getInvoiceType()->value,
                    ]
                ]
            ]
        ];
    }

    public function sendData($data)
    {
        $url = self::$host;

        $httpResponse = $this->httpClient->request(
            'post',
            $url,
        );
    }
}
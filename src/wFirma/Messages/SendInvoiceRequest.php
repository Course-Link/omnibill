<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Customer\HasCustomer;
use Omnibill\Common\Message\AbstractResponse;

class SendInvoiceRequest extends AbstractRequest
{
    use HasCustomer;

    public function getData(): array
    {
        return [
            'invoices' => [
                'parameters' => [
                    "0" => [
                        'parameter' => [
                            'name' => 'email',
                            'value' => $this->getCustomer()->getEmail(),
                        ]
                    ]
                ]
            ]
        ];
    }

    public function sendData($data): AbstractResponse
    {
        $invoiceId = $this->getInvoiceReference();
        $companyId = $this->getCompanyId();

        $endpoint = self::$host . "invoices/send/" . $invoiceId . "?outputFormat=json&inputFormat=json&companyId=" . $companyId . "&oauth_version=2";

        $response = $this->httpClient->request(
            'POST',
            $endpoint, [
            'Authorization' => 'Bearer ' . $this->getToken(),
            'Content-Type' => 'application/json',
        ], json_encode($data));

        return $this->response = new SendInvoiceResponse($this, $response->getBody()->getContents());
    }
}
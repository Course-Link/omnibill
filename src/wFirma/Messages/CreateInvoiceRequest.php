<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Customer\HasCustomer;
use Omnibill\Common\Message\AbstractResponse;

class CreateInvoiceRequest extends AbstractRequest
{
    use HasCustomer;

    public function getData(): array
    {
        $data = [
            'invoices' => [
                0 => [
                    'invoice' => [
                        'contractor' => [
                            "name" => $this->getCustomer()->getCompanyName() ?? $this->getCustomer()->getName(),
                            "street" => $this->getCustomer()->getAddress(),
                            "zip" => $this->getCustomer()->getPostcode(),
                            "city" => $this->getCustomer()->getCity(),
                            "email" => $this->getCustomer()->getEmail(),
                        ],
                        'type' => $this->getInvoiceType()->value,
                        "tax_evaluation_method" => "brutto",
                        "payment_date" => $this->getPaymentDate(),
                        "paymentmethod" => $this->getPaymentMethod(),
                        "date" => $this->getPaymentDate(),
                        "disposaldate" => $this->getPaymentDate(),
                        "id_external" => $this->getTransactionId(),
                        "auto_send" => true,
                        "alreadypaid_initial" => $this->getAmount(),
                        "invoicecontents" => [
                            "0" => [
                                "invoicecontent" => [
                                    "name" => $this->getDescription(),
                                    "count" => "1.0000",
                                    "unit_count" => "1.0000",
                                    "price" => $this->getAmount(),
                                    "unit" => "szt."
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if ($this->getCustomer()->getVatId()) {
            $data['invoices']['0']['invoice']['contractor']['nip'] = $this->getCustomer()->getVatId();
        }

        return $data;
    }

    public function sendData($data): AbstractResponse
    {
        $url = self::$host;

        // TODO Token
        $httpResponse = $this->httpClient->request(
            'post',
            $url,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getToken(),
            ],
            json_encode($data)
        );

        $data = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new CreateInvoiceResponse($this, $data);
    }
}
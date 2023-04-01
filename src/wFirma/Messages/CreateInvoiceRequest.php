<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Customer\HasCustomer;
use Omnibill\Common\Exception\AuthException;
use Omnibill\Common\Exception\InvalidRequestException;
use Omnibill\Common\Exception\InvalidResponseException;
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

    /**
     * @throws AuthException
     * @throws InvalidRequestException|InvalidResponseException
     */
    public function sendData($data): AbstractResponse
    {
        $endpoint = 'invoices/add';

        $data = $this->sendRequest('post', $endpoint, $data);

        if (isset($data['invoices'][0]['invoice']['errors'])) {
            throw new InvalidRequestException(json_encode($data['invoices'][0]['invoice']['errors']));
        }

        return $this->response = new CreateInvoiceResponse($this, $data);
    }
}
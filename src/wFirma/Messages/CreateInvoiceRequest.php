<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Customer\HasCustomer;
use Omnibill\Common\Exception\AuthException;
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
                        "alreadypaid_initial" => 35.55,
                        "invoicecontents" => [
                            "0" => [
                                "invoicecontent" => [
                                    "name" => $this->getDescription(),
                                    "count" => "1.0000",
                                    "unit_count" => "1.0000",
                                    "price" => 35.55,
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
     */
    public function sendData($data): AbstractResponse
    {
        $endpoint = 'invoices/add';

        $data = $this->sendRequest('post', $endpoint, $data);

        return $this->response = new CreateInvoiceResponse($this, $data);
    }
}
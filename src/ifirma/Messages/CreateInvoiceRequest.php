<?php

namespace Omnibill\ifirma\Messages;

class CreateInvoiceRequest extends AbstractRequest
{
    public function getData(): array
    {
        return [
            'Zaplacono' => $this->getAmount(),
            'LiczOd' => 'BRT',
            'DataWystawienia' => $data->issued_at->format('Y-m-d'),
            'DataSprzedazy' => $data->issued_at->format('Y-m-d'),
            'FormatDatySprzedazy' => 'DZN',
            'TerminPlatnosci' => $data->issued_at->format('Y-m-d'),
            'SposobZaplaty' => 'KAR',
            'RodzajPodpisuOdbiorcy' => 'BPO',
            'Uwagi' => config('app.name') . ' #' . $data->transaction_id,
            'WidocznyNumerGios' => true,
            'Numer' => NULL,
        ];
    }

    public function sendData($data): CreateInvoiceResponse
    {
        $url = self::$host . 'fakturakraj.json';
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
            json_encode($data),
        );

        $data = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new CreateInvoiceResponse($this, $data);
    }
}
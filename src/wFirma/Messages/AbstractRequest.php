<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Message\AbstractRequest as BaseRequest;
use Omnibill\wFirma\wFirmaCredentials;

abstract class AbstractRequest extends BaseRequest
{
    use wfirmaCredentials;

    protected static string $host = 'https://api2.wfirma.pl/';
}
<?php

namespace Omnibill\wFirma\Messages;

use Omnibill\Common\Message\AbstractRequest as BaseRequest;

abstract class AbstractRequest extends BaseRequest
{
    protected static string $host = 'https://api2.wfirma.pl/';
}
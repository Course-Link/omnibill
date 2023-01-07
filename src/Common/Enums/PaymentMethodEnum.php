<?php

namespace Omnibill\Common\Enums;

enum PaymentMethodEnum: string
{
    case CARD = 'card';
    case TRANSFER = 'transfer';
}

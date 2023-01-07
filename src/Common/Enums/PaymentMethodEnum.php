<?php

namespace Omnibill\Common\Enums;

enum PaymentMethodEnum: string
{
    case CASH = 'cash';
    case TRANSFER = 'transfer';
    case COMPENSATION = 'compensation';
    case CASH_ON_DELIVERY = 'cash_on_delivery';
    case PAYMENT_CARD = 'payment_card';
}

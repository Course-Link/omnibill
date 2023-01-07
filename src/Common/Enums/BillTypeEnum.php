<?php

namespace Omnibill\Common\Enums;

enum BillTypeEnum: string
{
    case BILL = 'bill';
    case PROFORMA = 'proforma';
    case OFFER = 'offer';
    case RECEIPT = 'receipt';
    case RECEIPT_FISCAL = 'receipt_fiscal';
    case OTHER = 'income_bill';
}

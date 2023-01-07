<?php

namespace Omnibill\Common\Enums;

enum InvoiceTypeEnum: string
{
    case VAT = 'normal';
    case VAT_MARGIN = 'margin';
    case PROFORMA = 'proforma';
    case OFFER = 'offer';
    case RECEIPT = 'receipt';
    case RECEIPT_FISCAL = 'receipt_fiscal';
    case OTHER = 'income_normal';
}

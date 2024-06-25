<?php

namespace App\Enum;

enum WordsAmountFilterModeEnum: string
{
    case EXACT = 'exact';
    case MORE_THAN = 'more_than';
    case LESS_THAN = 'less_than';
}

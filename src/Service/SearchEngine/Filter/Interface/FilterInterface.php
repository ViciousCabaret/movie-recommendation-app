<?php

namespace App\Service\SearchEngine\Filter\Interface;

use App\Enum\FilterTypeEnum;
use Closure;

interface FilterInterface
{
    public function getFilterAlgorithm(): Closure;

    public function getFilterType(): FilterTypeEnum;
}

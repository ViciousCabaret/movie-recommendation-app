<?php

namespace App\Service\SearchEngine\Filter;

use App\Enum\FilterTypeEnum;
use App\Service\SearchEngine\Filter\Interface\FilterableInterface;
use App\Service\SearchEngine\Filter\Interface\FilterInterface;
use Closure;

readonly class EvenLettersAmountFilter implements FilterInterface
{
    public function getFilterAlgorithm(): Closure
    {
        return function (FilterableInterface $filterable) {
            if (trim(strlen($filterable->getFilterableField())) % 2 == 0) {
                return $filterable;
            }
            return null;
        };
    }

    public function getFilterType(): FilterTypeEnum
    {
        return FilterTypeEnum::SINGLE_TYPE;
    }
}

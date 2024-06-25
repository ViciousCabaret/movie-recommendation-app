<?php

namespace App\Service\SearchEngine\Filter;

use App\Enum\FilterTypeEnum;
use App\Service\SearchEngine\Filter\Interface\FilterableInterface;
use App\Service\SearchEngine\Filter\Interface\FilterInterface;
use Closure;

readonly class StartsWithLetterFilter implements FilterInterface
{
    public function __construct(
        private string $letter,
    ) {
    }

    public function getFilterAlgorithm(): Closure
    {
        return function (FilterableInterface $filterable) {
            if (stripos($filterable->getFilterableField(), $this->letter) === 0) {
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

<?php

namespace App\Service\SearchEngine\Filter;

use App\Enum\FilterTypeEnum;
use App\Enum\WordsAmountFilterModeEnum;
use App\Service\SearchEngine\Filter\Interface\FilterableInterface;
use App\Service\SearchEngine\Filter\Interface\FilterInterface;
use Closure;

readonly class WordsAmountFilter implements FilterInterface
{
    public function __construct(
        private WordsAmountFilterModeEnum $modeEnum,
        private int $wordsAmount,
    ) {
    }

    public function getFilterAlgorithm(): Closure
    {
        return function (FilterableInterface $filterable) {
            if ($this->modeEnum === WordsAmountFilterModeEnum::EXACT) {
                if (count(explode(' ', trim($filterable->getFilterableField()))) == $this->wordsAmount) {
                    return $filterable;
                }
            }
            if ($this->modeEnum === WordsAmountFilterModeEnum::MORE_THAN) {
                if (count(explode(' ', trim($filterable->getFilterableField()))) > $this->wordsAmount) {
                    return $filterable;
                }
            };

            return null;
        };
    }

    public function getFilterType(): FilterTypeEnum
    {
        return FilterTypeEnum::SINGLE_TYPE;
    }
}

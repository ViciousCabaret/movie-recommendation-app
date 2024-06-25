<?php

namespace App\Service\SearchEngine\Filter;

use App\Enum\FilterTypeEnum;
use App\Service\SearchEngine\Filter\Interface\FilterInterface;
use Closure;

readonly class RandomizationFilter implements FilterInterface
{
    public function __construct(
        private int $amount,
    ) {
    }

    public function getFilterAlgorithm(): Closure
    {
        return function (array $filterableCollection) {
            if (count($filterableCollection) < $this->amount) {
                return $filterableCollection;
            }
            $randomKeys = array_rand($filterableCollection, $this->amount);
            $results = [];
            foreach ($randomKeys as $randomKey) {
                $results[] = $filterableCollection[$randomKey];
            }

            return $results;
        };
    }

    public function getFilterType(): FilterTypeEnum
    {
        return FilterTypeEnum::COLLECTION_TYPE;
    }
}

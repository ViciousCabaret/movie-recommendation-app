<?php

namespace App\Service\SearchEngine\Filter\TypeResolver;

use App\Service\SearchEngine\Filter\Interface\FilterableInterface;
use App\Service\SearchEngine\Filter\Interface\FilterInterface;

class SingleFilterTypeResolver extends AbstractFilterTypeResolver
{
    public function filter(): array
    {
        $results = [];

        /** @var FilterableInterface $filterableItem */
        foreach ($this->filterableItems as $filterableItem) {
            $result = [];

            /** @var FilterInterface $filter */
            foreach ($this->filters as $filter) {
                $function = $filter->getFilterAlgorithm();
                $result[] = $function($filterableItem);
            }

            if (!in_array(null, $result)) {
                $results[] = $filterableItem;
            }
        }

        return $results;
    }
}

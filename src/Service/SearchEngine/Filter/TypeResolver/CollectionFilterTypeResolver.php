<?php

namespace App\Service\SearchEngine\Filter\TypeResolver;

use App\Service\SearchEngine\Filter\Interface\FilterInterface;

class CollectionFilterTypeResolver extends AbstractFilterTypeResolver
{
    public function filter(): array
    {
        $items = $this->filterableItems;
        /** @var FilterInterface $filter */
        foreach ($this->filters as $filter) {
            $filterAlgorithm = $filter->getFilterAlgorithm();
            $items = $filterAlgorithm($items);
        }

        return $items;
    }
}

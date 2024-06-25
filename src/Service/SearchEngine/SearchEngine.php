<?php

namespace App\Service\SearchEngine;

use App\DataProvider\Interface\DataProviderInterface;
use App\Enum\FilterTypeEnum;
use App\Service\SearchEngine\Filter\Interface\FilterInterface;
use App\Service\SearchEngine\Filter\TypeResolver\CollectionFilterTypeResolver;
use App\Service\SearchEngine\Filter\TypeResolver\SingleFilterTypeResolver;

readonly class SearchEngine
{
    public function __construct(
        private DataProviderInterface $dataProvider,
    ) {
    }

    public function search(array $filters): array
    {
        $filterableItems = $this->dataProvider->getAll();

        [$singleTypeFilters, $collectionTypeFilters] = $this->separateFilterTypes($filters);

        $results = (new SingleFilterTypeResolver($filterableItems, $singleTypeFilters))->filter();

        if (count($singleTypeFilters) == 0) {
            $results = $filterableItems;
        }

        $results = (new CollectionFilterTypeResolver($results, $collectionTypeFilters))->filter();

        return $results;
    }

    private function separateFilterTypes(array $filters): array
    {
        $singleTypeFilters = [];
        $collectionTypeFilters = [];

        /** @var FilterInterface $filter */
        foreach ($filters as $filter) {
            if ($filter->getFilterType() === FilterTypeEnum::SINGLE_TYPE) {
                $singleTypeFilters[] = $filter;
                continue;
            }
            $collectionTypeFilters[] = $filter;
        }

        return [$singleTypeFilters, $collectionTypeFilters];
    }
}

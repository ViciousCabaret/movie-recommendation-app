<?php

namespace App\Tests\Unit\Utils;

use App\Service\SearchEngine\Filter\Interface\FilterableInterface;

class FilterableProviderUtil
{
    public static function createFilterableObjectsFromString(array $data): array
    {
        $filterableObjects = [];
        foreach ($data as $datum) {
            $filterableObjects[] = new readonly class($datum) implements FilterableInterface {
                public function __construct(private string $title) {}
                public function getTitle(): string
                {
                    return $this->title;
                }
                public function getFilterableField(): string
                {
                    return $this->title;
                }
            };
        }

        return $filterableObjects;
    }
}
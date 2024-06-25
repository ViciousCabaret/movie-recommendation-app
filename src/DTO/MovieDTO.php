<?php

namespace App\DTO;

use App\Service\SearchEngine\Filter\Interface\FilterableInterface;

readonly class MovieDTO implements FilterableInterface
{
    public function __construct(
        private string $title,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFilterableField(): string
    {
        return $this->title;
    }
}

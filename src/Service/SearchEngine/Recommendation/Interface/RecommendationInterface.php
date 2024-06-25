<?php

namespace App\Service\SearchEngine\Recommendation\Interface;

use App\Enum\RecommendationAlgorithmEnum;

interface RecommendationInterface
{
    public function getSearchFilters(): array;

    public function getName(): RecommendationAlgorithmEnum;
}

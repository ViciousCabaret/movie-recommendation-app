<?php

namespace App\CQRS\Query;

use App\Enum\RecommendationAlgorithmEnum;

readonly class GetMovieRecommendationsQuery
{
    public function __construct(
        private RecommendationAlgorithmEnum $algorithmEnum,
    ) {
    }

    public function getAlgorithmEnum(): RecommendationAlgorithmEnum
    {
        return $this->algorithmEnum;
    }
}

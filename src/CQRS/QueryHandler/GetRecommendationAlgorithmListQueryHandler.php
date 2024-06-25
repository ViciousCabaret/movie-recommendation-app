<?php

namespace App\CQRS\QueryHandler;

use App\CQRS\Query\GetRecommendationAlgorithmListQuery;
use App\Enum\RecommendationAlgorithmEnum;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetRecommendationAlgorithmListQueryHandler
{
    public function __invoke(GetRecommendationAlgorithmListQuery $query): array
    {
        return RecommendationAlgorithmEnum::cases();
    }
}

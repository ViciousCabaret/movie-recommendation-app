<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\CQRS\Query\GetRecommendationAlgorithmListQuery;
use App\CQRS\Query\GetMovieRecommendationsQuery;
use App\DTO\MovieDTO;
use App\Enum\RecommendationAlgorithmEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movies')]
class MovieController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/recommendations/list')]
    public function recommendationsList(): JsonResponse
    {
        $data = $this->messageBus->dispatch(
            new GetRecommendationAlgorithmListQuery()
        )->last(HandledStamp::class)->getResult();

        return $this->json([
            'response' => $data,
        ]);
    }

    #[Route('/recommendations/{recommendation}')]
    public function recommendations(RecommendationAlgorithmEnum $recommendation): JsonResponse
    {
        $results = $this->messageBus->dispatch(
            new GetMovieRecommendationsQuery($recommendation)
        )->last(HandledStamp::class)->getResult();

        $results = array_map(function (MovieDTO $movie) {
            return $movie->getTitle();
        }, $results);

        return $this->json([
            'response' => $results,
        ]);
    }
}

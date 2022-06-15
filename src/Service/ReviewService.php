<?php

namespace App\Service;

use App\Entity\Review;
use App\Repository\ReviewRepository;

class ReviewService
{
    public function __construct(
        private ReviewRepository $repository
    ) {
    }

    public function all(): ?array
    {
        return $this->repository->findBy([], array('id' => 'DESC'));
    }

    public function getById(int $id): ?Review
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function getByFilmId(int $id): array
    {
        return $this->repository->findBy(['filmId' => $id]);
    }

    public function increaseGoodVotes(Review $review): Review
    {
        $votes = $review->getGoodVotes();
        $votes = $votes + 1;
        $review->setGoodVotes($votes);
        return $review;
    }

    public function increaseBadVotes(Review $review): Review
    {
        $votes = $review->getBadVotes();
        $votes = $votes + 1;
        $review->setBadVotes($votes);
        return $review;
    }
}
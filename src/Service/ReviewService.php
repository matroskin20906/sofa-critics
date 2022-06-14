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

    public function increaseGoodVotes(Review $review): Review
    {
        $arrayVotes = $review->getVotes();
        $arrayVotes['good'] = $arrayVotes['good'] + 1;
        $review->setVotes($arrayVotes);
        return $review;
    }

    public function increaseBadVotes(Review $review): Review
    {
        $arrayVotes = $review->getVotes();
        $arrayVotes['bad'] = $arrayVotes['bad'] + 1;
        $review->setVotes($arrayVotes);
        return $review;
    }
}
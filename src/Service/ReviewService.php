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
}
<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $repository
    ) {
    }

    public function all(): ?array
    {
        return $this->repository->findBy([], array('id' => 'DESC'));
    }

    public function getById(int $id): ?User
    {
        return $this->repository->findOneBy(['id' => $id], array('id' => 'DESC'));
    }
}
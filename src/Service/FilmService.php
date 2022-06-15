<?php

namespace App\Service;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Symfony\Component\HttpFoundation\Response;

class FilmService
{
    public function __construct(
        private FilmRepository $repository
    ){
    }

    public function all(): ?array
    {
        return $this->repository->findBy([], array('id' => 'DESC'));
    }

    public function findById(int $id): ?Film
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function findByDirector(string $director): ?array
    {
        return $this->repository->findBy(['director' => $director], array('id' => 'DESC'));
    }

    public function findByName(string $name): ?array
    {
        return $this->repository->findBy(['name' => $name], array('id' => 'DESC'));
    }

    public function findNFilms(int $page, int $n): ?array
    {
        $arrResult = [];
        $page--;
        $start = $n * $page + 1;
        $stop = $start + $n;
        for ($i = $start; $i < $stop; $i++) {
            $arrResult[] = $this->findById($i);
        }
        return $arrResult;
    }

    public function create(?Film $film): Response
    {
        return $this->repository->create($film);
    }

    public function update(?Film $film): Response
    {
        return $this->repository->update($film);
    }

}
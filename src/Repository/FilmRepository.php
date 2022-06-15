<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method createNotFoundException(string $string)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private ValidatorInterface $validator
    ) {
        parent::__construct($registry, Film::class);
    }

    /**
     * @return Film[]
     */
    public function findAllWithActor(string $actor): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT f
            FROM App\Entity\Film f
            WHERE f.actors like %actor%'
        )->setParameter('actor', $actor);
        return $query->getResult();
    }

    /**
     * @return Film[]
     */
    public function findAllWithKeyword(string $keyword): array
    {
        $entityManager = $this->getEntityManager();
        $qb = $this->_em->createQueryBuilder();
        $qb->select('f')
            ->from('App\Entity\Film', 'f')
            ->andWhere("f.keywords LIKE '%".$keyword."%'");
        $result = $qb->getQuery()->getResult();
        return $result;
    }

    public function create(Film $film): Response
    {
        $errors = $this->validator->validate($film);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $this->_em->persist($film);
        $this->_em->flush();

        return new Response("Create new film with id" . $film->getId());
    }

    public function update(?Film $film): Response
    {
        $errors = $this->validator->validate($film);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $this->_em->persist($film);
        $this->_em->flush();

        return new Response('Updated film with id ' . $film->getId());
    }

    /**
     * @throws Exception
     */
    public function delete(): Response
    {
        if (!empty($this->_em->createQuery('DELETE App\Entity\Film a WHERE a.id > 0')->execute())) {
            $this
                ->_em
                ->getConnection()
                ->prepare('ALTER SEQUENCE app.film_id_seq RESTART with 1;')
                ->executeQuery();
            return new Response('Deleted');
        }

        return new Response('Nothing to delete');
    }

}
<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method createNotFoundException(string $string)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private ValidatorInterface $validator
    ) {
        parent::__construct($registry, Review::class);
    }

    public function create(Review $review): Response
    {
        $errors = $this->validator->validate($review);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $this->_em->persist($review);
        $this->_em->flush();

        return new Response("Create new review with id" . $review->getId());
    }

    public function update(?Review $review): Response
    {
        $errors = $this->validator->validate($review);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $this->_em->persist($review);
        $this->_em->flush();

        return new Response('Updated review with id ' . $review->getId());
    }

    /**
     * @throws Exception
     */
    public function delete(): Response
    {
        if (!empty($this->_em->createQuery('DELETE App\Entity\Review a WHERE a.id > 0')->execute())) {
            $this
                ->_em
                ->getConnection()
                ->prepare('ALTER SEQUENCE app.review_id_seq RESTART with 1;')
                ->executeQuery();
            return new Response('Deleted');
        }

        return new Response('Nothing to delete');
    }
}
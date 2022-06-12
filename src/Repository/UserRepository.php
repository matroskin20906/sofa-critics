<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method createNotFoundException(string $string)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private ValidatorInterface $validator
    ) {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[]
     */
    public function  getByRole(string $role): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT u
            FROM App\Entity\User u
            WHERE u.roles like %role%'
        )->setParameter('role', $role);
        return $query->getResult();
    }

    public function create(User $user): Response
    {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $this->_em->persist($user);
        $this->_em->flush();

        return new Response("Create new user with id" . $user->getUserIdentifier());
    }

    public function update(?User $user): Response
    {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string)$errors, 400);
        }

        $this->_em->persist($user);
        $this->_em->flush();

        return new Response('Updated user with id ' . $user->getUserIdentifier());
    }

    /**
     * @throws Exception
     */
    public function delete(): Response
    {
        if (!empty($this->_em->createQuery('DELETE App\Entity\User a WHERE a.id > 0')->execute())) {
            $this
                ->_em
                ->getConnection()
                ->prepare('ALTER SEQUENCE app.my_user_id_seq RESTART with 1;')
                ->executeQuery();
            return new Response('Deleted');
        }

        return new Response('Nothing to delete');
    }
}
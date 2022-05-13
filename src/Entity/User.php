<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


//TODO: implement registration form
#[
    UniqueEntity('hash'),
    Entity(repositoryClass: UserRepository::class),
]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private ?int $id = null;
    private string $password = '1111';
    private array $roles = [];

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->id;
    }
}

<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


//TODO: implement registration form
#[
    UniqueEntity('hash'),
    Entity(repositoryClass: UserRepository::class),
    ORM\Table(name: 'app.user')
]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[
        ORM\Id,
        ORM\Column(type: 'integer'),
        ORM\GeneratedValue(strategy: "SEQUENCE"),
        ORM\SequenceGenerator(sequenceName: "app.user_id_seq", allocationSize: 1, initialValue: 1)
    ]
    private ?int $id = null;

    #[
        ORM\Column(type: 'string', length: 255, nullable: false),
        Assert\NotBlank,
        Assert\Type(type: 'string'),
        Assert\Length(max: 255)
    ]
    private string $password = '1111';

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

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

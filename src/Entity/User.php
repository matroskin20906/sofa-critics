<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
#[
    ORM\Table(name: "`user`"),
    ORM\Entity(repositoryClass: UserRepository::class),
    UniqueEntity('id'),
    UniqueEntity('username'),
]
#[UniqueEntity(fields: ['password'], message: 'There is already an account with this password')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    public const ROLE_USER = 'USER';
    public const ROLE_ADMIN = 'ADMIN';
    public const ROLE_GUEST = 'GUEST';

    #[
        ORM\Column(type: 'string', length: 40, nullable: false),
        Assert\NotBlank,
        Assert\Type(type: 'string'),
        Assert\Length(max: 40)
    ]
    private string $username = "name";

    #[
        ORM\Id,
        ORM\Column(type: 'integer'),
        ORM\GeneratedValue
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

    #[
        ORM\Column(type: 'string', length: 255, nullable: true)
    ]
    private ?string $photo = null;

    /**
     * @Vich\UploadableField(mapping="user", fileNameProperty="photo")
     * @var File|null
      */
    private ?File $photoFile = null;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

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
        $roles = $this->roles;
        $roles[] = self::ROLE_USER;

        return array_unique($roles);
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPhoto(): ?string{
        return $this->photo;
    }

    /**
     * @param string|null $photo
     * @return $this
     */
    public function setPhoto(?string $photo): self {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getPhotoFile(): ?File {
        return $this->photoFile;
    }

    /**
     * @param File|null $photoFile
     */
    public function setPhotoFile(?File $photoFile = null) {
        $this->photoFile = $photoFile;
    }

}

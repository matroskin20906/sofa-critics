<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @Vich\Uploadable
 */
#[
    ORM\Table(name: "`film`"),
    Entity(repositoryClass: FilmRepository::class),
    UniqueEntity('id'),
]
class Film
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column(type: 'integer'),
    ]
    private ?int $id = null;

    #[
        ORM\Column(type: 'string', length: 40, nullable: false),
        Assert\NotBlank,
        Assert\Type(type: 'string'),
        Assert\Length(max: 40)
    ]
    private ?string $name = null;

    #[
        ORM\Column(type: 'string', length: 40, nullable: false),
        Assert\NotBlank,
        Assert\Type(type: 'string'),
        Assert\Length(max: 40)
    ]
    private ?string $director = null;

    #[
        ORM\Column(type: 'string', length: 1024, nullable: false),
        Assert\NotBlank,
        Assert\Type(type: 'string'),
        Assert\Length(max: 1024)
    ]
    private ?string $actors = null;

    #[
        ORM\Column(type: 'json'),
        ORM\OneToMany(targetEntity: "App\Entity\Review")
    ]
    private array $reviews = [];

    #[
        ORM\Column(type: 'string', length: 1024, nullable: false),
        Assert\NotBlank,
        Assert\Type(type: 'string'),
        Assert\Length(max: 1024)
    ]
    private ?string $keywords = null;

    #[
        ORM\Column(type: 'string', length: 255, nullable: true)
    ]
    private ?string $photo = null;

    /**
     * @Vich\UploadableField(mapping="film", fileNameProperty="photo")
     * @var File|null
     */
    private ?File $photoFile = null;

    public function addKeyword(string $keyword): void
    {
        $this->keywords[] = $keyword;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDirector(): ?string
    {
        return $this->director;
    }

    /**
     * @param string|null $director
     */
    public function setDirector(?string $director): void
    {
        $this->director = $director;
    }

    /**
     * @return string
     */
    public function getActors(): string
    {
        return $this->actors;
    }

    /**
     * @param string $actors
     */
    public function setActors(string $actors): void
    {
        $this->actors = $actors;
    }

    /**
     * @return array
     */
    public function getReviews(): array
    {
        return $this->reviews;
    }

    /**
     * @param array $reviews
     */
    public function setReviews(array $reviews): void
    {
        $this->reviews = $reviews;
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
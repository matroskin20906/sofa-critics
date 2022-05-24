<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[
    ORM\Table(name:'app.film'),
    UniqueEntity('id'),
]
class Film
{
    #[
        ORM\Id,
        ORM\Column(type: 'integer'),
        ORM\GeneratedValue(strategy: "SEQUENCE"),
        ORM\SequenceGenerator(sequenceName: "app.film_id_seq", allocationSize: 1, initialValue: 1)
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

    #[ORM\Column(type: 'json')]
    private array $actors = [];

    #[ORM\Column(type: 'json')]
    private array $reviews = [];

    #[ORM\Column(type: 'json')]
    private array $keywords = [];

    /**
     * @return array
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * @param array $keywords
     */
    public function setKeywords(array $keywords): void
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
     * @return array
     */
    public function getActors(): array
    {
        return $this->actors;
    }

    /**
     * @param array $actors
     */
    public function setActors(array $actors): void
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


}
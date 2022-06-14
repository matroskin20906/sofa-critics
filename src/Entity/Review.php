<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[
    ORM\Entity(repositoryClass: ReviewRepository::class),
    UniqueEntity('hash'),
]
class Review
{
    #[
        ORM\Id,
        ORM\Column(type: 'integer'),
        ORM\GeneratedValue(strategy: "SEQUENCE"),
        ORM\SequenceGenerator(sequenceName: "app.review_id_seq", allocationSize: 1, initialValue: 1)
    ]
    private ?int $id = null;

    #[
        ORM\Column(type: 'integer'),
    ]
    private ?int $authorId = null;

    #[
        ORM\Column(type: 'string'),
        Assert\NotBlank,
        Assert\Type(type: 'string'),
        Assert\Length(max: 255)
    ]
    private ?string $title = null;
    private array $content = [];
    private array $votes = [];

    /**
     * @return array
     */
    public function getVotes(): array
    {
        return $this->votes;
    }

    /**
     * @param array $votes
     */
    public function setVotes(array $votes): void
    {
        $this->votes = $votes;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int|null $authorId
     */
    public function setAuthorId(?int $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param array $content
     */
    public function setContent(array $content): void
    {
        $this->content = $content;
    }


}
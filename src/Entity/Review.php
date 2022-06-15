<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[
    ORM\Entity(repositoryClass: ReviewRepository::class),
    UniqueEntity('id'),
]
class Review
{
    #[
        ORM\Id,
        ORM\Column(type: 'integer'),
        ORM\GeneratedValue
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

    #[
        ORM\Column(type: 'string'),
        Assert\NotBlank,
        Assert\Type(type: 'string'),
        Assert\Length(max: 2048)
    ]
    private ?string $content = null;

    #[
        ORM\Column(type: 'integer')
    ]
    private int $goodVotes = 0;

    #[
        ORM\Column(type: 'integer')
    ]
    private int $badVotes = 0;

    #[
        ORM\Column(type: 'integer'),
        ORM\ManyToOne(targetEntity: "App\Entity\Film")
    ]
    private int $filmId;

    #[
        ORM\Column(type: 'string'),
        Assert\Type(type: 'string'),
        Assert\Length(max: 2048)
    ]
    private ?string $reactBy = null;

    /**
     * @return string|null
     */
    public function getReactBy(): ?string
    {
        return $this->reactBy;
    }

    /**
     * @param string|null $reactBy
     */
    public function setReactBy(?string $reactBy): void
    {
        $this->reactBy = $reactBy;
    }

    /**
     * @return int
     */
    public function getFilmId(): int
    {
        return $this->filmId;
    }

    /**
     * @param int $filmId
     */
    public function setFilmId(int $filmId): void
    {
        $this->filmId = $filmId;
    }

    /**
     * @return int|null
     */
    public function getGoodVotes(): ?int
    {
        return $this->goodVotes;
    }

    /**
     * @param int $goodVotes
     */
    public function setGoodVotes(int $goodVotes): void
    {
        $this->goodVotes = $goodVotes;
    }

    /**
     * @return int|null
     */
    public function getBadVotes(): ?int
    {
        return $this->badVotes;
    }

    /**
     * @param int $badVotes
     */
    public function setBadVotes(int $badVotes): void
    {
        $this->badVotes = $badVotes;
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
     * @return string
     */
    public function getContent(): string
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
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }


}
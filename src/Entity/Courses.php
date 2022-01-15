<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Courses
 *
 * @ORM\Table(name="courses")
 * @ORM\Entity
 */
class Courses
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=254, nullable=true)
     */
    private $title;

    /**
     * @var int|null
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="oldPrice", type="integer", nullable=true)
     */
    private $oldprice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="duration", type="string", length=20, nullable=true)
     */
    private $duration;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbLesson", type="integer", nullable=true)
     */
    private $nblesson;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbReview", type="integer", nullable=true)
     */
    private $nbreview;

    /**
     * @var string|null
     *
     * @ORM\Column(name="overview", type="text", length=65535, nullable=true)
     */
    private $overview;

    /**
     * @var string|null
     *
     * @ORM\Column(name="metaUrl", type="string", length=254, nullable=true)
     */
    private $metaUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="metaDescription", type="string", length=254, nullable=true)
     */
    private $metaDescription;

    /**
     * @var boolean|null
     *
     * @ORM\Column(name="isPublished", type="boolean")
     */
    private $isPublished;

    /**
     * @var string|null
     *
     * @ORM\Column(name="video", type="string", length=254, nullable=true)
     */
    private $video;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=254, nullable=true)
     */
    private $image;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdat;

    public function __construct()
    {
        $this->createdat = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     */
    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getOldprice(): ?int
    {
        return $this->oldprice;
    }

    /**
     * @param int|null $oldprice
     */
    public function setOldprice(?int $oldprice): void
    {
        $this->oldprice = $oldprice;
    }

    /**
     * @return string|null
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @param string|null $duration
     */
    public function setDuration(?string $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return int|null
     */
    public function getNblesson(): ?int
    {
        return $this->nblesson;
    }

    /**
     * @param int|null $nblesson
     */
    public function setNblesson(?int $nblesson): void
    {
        $this->nblesson = $nblesson;
    }

    /**
     * @return int|null
     */
    public function getNbreview(): ?int
    {
        return $this->nbreview;
    }

    /**
     * @param int|null $nbreview
     */
    public function setNbreview(?int $nbreview): void
    {
        $this->nbreview = $nbreview;
    }

    /**
     * @return null|string
     */
    public function getOverview(): ?string
    {
        return $this->overview;
    }

    /**
     * @param null|string $overview
     */
    public function setOverview(?string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return null|string
     */
    public function getMetaUrl(): ?string
    {
        return $this->metaUrl;
    }

    /**
     * @param null|string $metaUrl
     */
    public function setMetaUrl(?string $metaUrl): void
    {
        $this->metaUrl = $metaUrl;
    }

    /**
     * @return null|string
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @param null|string $metaDescription
     */
    public function setMetaDescription(?string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return bool|null
     */
    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    /**
     * @param bool|null $isPublished
     */
    public function setIsPublished(?bool $isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return null|string
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @param null|string $video
     */
    public function setVideo(?string $video): void
    {
        $this->video = $video;
    }

    /**
     * @return null|string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param null|string $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedat(): ?\DateTime
    {
        return $this->createdat;
    }

    /**
     * @param \DateTime|null $createdat
     */
    public function setCreatedat(?\DateTime $createdat): void
    {
        $this->createdat = $createdat;
    }

}

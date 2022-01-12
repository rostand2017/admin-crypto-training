<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Lesson
 *
 * @ORM\Table(name="lesson", indexes={@ORM\Index(name="FK_Association_2", columns={"module_id"})})
 * @ORM\Entity
 */
class Lesson
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="lessonNumber", type="integer", nullable=true)
     */
    private $lessonnumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="smallDescription", type="text", length=65535, nullable=true)
     */
    private $smalldescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="duration", type="string", length=20, nullable=true)
     */
    private $duration;

    /**
     * @var string|null
     *
     * @ORM\Column(name="video", type="string", length=254, nullable=true)
     */
    private $video;

    /**
     * @var Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     * })
     */
    private $module;

    /**
     * @var PersistentCollection
     * @ORM\OneToMany(targetEntity="Supportfiles", mappedBy="lesson", cascade={"persist", "remove"})
     */
    private  $supportFiles;

    public function __construct()
    {
        $this->createdat = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
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
    public function getLessonnumber(): ?int
    {
        return $this->lessonnumber;
    }

    /**
     * @param int|null $lessonnumber
     */
    public function setLessonnumber(?int $lessonnumber): void
    {
        $this->lessonnumber = $lessonnumber;
    }

    /**
     * @return null|string
     */
    public function getSmalldescription(): ?string
    {
        return $this->smalldescription;
    }

    /**
     * @param null|string $smalldescription
     */
    public function setSmalldescription(?string $smalldescription): void
    {
        $this->smalldescription = $smalldescription;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
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
     * @return Module
     */
    public function getModule(): Module
    {
        return $this->module;
    }

    /**
     * @param Module $module
     */
    public function setModule(Module $module): void
    {
        $this->module = $module;
    }

    /**
     * @return null|string
     */
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    /**
     * @param null|string $duration
     */
    public function setDuration(?string $duration): void
    {
        $this->duration = $duration;
    }
    /**
     * @return PersistentCollection
     */
    public function getSupportFiles(): PersistentCollection
    {
        return $this->supportFiles;
    }

    /**
     * @param PersistentCollection $supportFiles
     */
    public function setSupportFiles(PersistentCollection $supportFiles): void
    {
        $this->supportFiles = $supportFiles;
    }
}

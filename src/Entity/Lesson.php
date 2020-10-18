<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Lesson
 *
 * @ORM\Table(name="lesson", indexes={@ORM\Index(name="FK_Association_3", columns={"Module"})})
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=254, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="video", type="string", length=254, nullable=true)
     */
    private $video;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat;

    /**
     * @var Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Module", referencedColumnName="id")
     * })
     */
    private $module;

    /**
     * @var PersistentCollection
     * @ORM\OneToMany(targetEntity="Section", mappedBy="lesson", cascade={"persist", "remove"})
     */
    private  $sections;

    /**
     * @var PersistentCollection
     * @ORM\OneToMany(targetEntity="Supportfiles", mappedBy="lesson", cascade={"persist", "remove"})
     */
    private  $supportFiles;

    public function __construct()
    {
        $this->createdat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getSections(): PersistentCollection
    {
        return $this->sections;
    }

    /**
     * @param PersistentCollection $sections
     */
    public function setSections(PersistentCollection $sections): void
    {
        $this->sections = $sections;
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

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * Module
 *
 * @ORM\Table(name="module", indexes={@ORM\Index(name="FK_Association_1", columns={"courses_id"})})
 * @ORM\Entity
 */
class Module
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
     * @var string|null
     *
     * @ORM\Column(name="duration", type="string", length=10, nullable=true)
     */
    private $duration;

    /**
     * @var int|null
     *
     * @ORM\Column(name="moduleNumber", type="integer", nullable=true)
     */
    private $modulenumber;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var Courses
     *
     * @ORM\ManyToOne(targetEntity="Courses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="courses_id", referencedColumnName="id")
     * })
     */
    private $courses;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="module")
     */
    private $lessons;


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
    public function getModulenumber(): ?int
    {
        return $this->modulenumber;
    }

    /**
     * @param int|null $modulenumber
     */
    public function setModulenumber(?int $modulenumber): void
    {
        $this->modulenumber = $modulenumber;
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

    /**
     * @return Courses
     */
    public function getCourses(): Courses
    {
        return $this->courses;
    }

    /**
     * @param Courses $courses
     */
    public function setCourses(Courses $courses): void
    {
        $this->courses = $courses;
    }

    /**
     * @return Collection
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    /**
     * @param Collection $lessons
     */
    public function addLesson(Lesson $lesson): void
    {
        $this->lessons->add($lesson);
    }

}

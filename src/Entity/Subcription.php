<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subcription
 *
 * @ORM\Table(name="subcription", indexes={@ORM\Index(name="FK_Association_8", columns={"Course"}), @ORM\Index(name="FK_Association_7", columns={"User"})})
 * @ORM\Entity
 */
class Subcription
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
     * @var int|null
     *
     * @ORM\Column(name="lesson", type="integer", nullable=true)
     */
    private $lesson;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbLesson", type="integer", nullable=true)
     */
    private $nblesson;

    /**
     * @var string|null
     *
     * @ORM\Column(name="linkCurrentLesson", type="string", length=255, nullable=true)
     */
    private $linkcurrentlesson;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="User", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Course", referencedColumnName="id")
     * })
     */
    private $course;

    public function __construct()
    {
        $this->createdat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLesson(): ?int
    {
        return $this->lesson;
    }

    public function setLesson(?int $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }

    public function getNblesson(): ?int
    {
        return $this->nblesson;
    }

    public function setNblesson(?int $nblesson): self
    {
        $this->nblesson = $nblesson;

        return $this;
    }

    public function getLinkcurrentlesson(): ?string
    {
        return $this->linkcurrentlesson;
    }

    public function setLinkcurrentlesson(?string $linkcurrentlesson): self
    {
        $this->linkcurrentlesson = $linkcurrentlesson;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }


}

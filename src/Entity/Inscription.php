<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscription
 *
 * @ORM\Table(name="inscription", indexes={@ORM\Index(name="FK_Association_3", columns={"user_id"}), @ORM\Index(name="FK_Association_6", columns={"courses_id"})})
 * @ORM\Entity
 */
class Inscription
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
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="progression", type="integer", nullable=true)
     */
    private $progression;

    /**
     * @var int|null
     *
     * @ORM\Column(name="currentLesson", type="integer", nullable=true)
     */
    private $currentLesson;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Courses
     *
     * @ORM\ManyToOne(targetEntity="Courses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="courses_id", referencedColumnName="id")
     * })
     */
    private $courses;

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
    public function getProgression(): ?int
    {
        return $this->progression;
    }

    /**
     * @param int|null $progression
     */
    public function setProgression(?int $progression): void
    {
        $this->progression = $progression;
    }

    /**
     * @return int|null
     */
    public function getCurrentLesson(): ?int
    {
        return $this->currentLesson;
    }

    /**
     * @param int|null $currentLesson
     */
    public function setCurrentLesson(?int $currentLesson): void
    {
        $this->currentLesson = $currentLesson;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
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

}

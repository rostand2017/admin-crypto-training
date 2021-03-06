<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Supportfiles
 *
 * @ORM\Table(name="supportfiles", indexes={@ORM\Index(name="FK_Association_5", columns={"Lesson"})})
 * @ORM\Entity
 */
class Supportfiles
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
     * @ORM\Column(name="path", type="string", nullable=false)
     */
    private $path;

    /**
     * @var Lesson
     *
     * @ORM\ManyToOne(targetEntity="Lesson")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Lesson", referencedColumnName="id")
     * })
     */
    private $lesson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }
}
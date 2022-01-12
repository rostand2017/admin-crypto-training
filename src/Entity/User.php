<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(name="email", type="string", length=254, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=254, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=254, nullable=true)
     */
    private $password;

    /**
     * @var array|null
     *
     * @ORM\Column(name="roles", type="json")
     */
    private $roles;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=254, nullable=true)
     */
    private $photo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbCourses", type="integer", nullable=true)
     */
    private $nbcourses;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbCompletedCourses", type="integer", nullable=true)
     */
    private $nbcompletedcourses;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="job", type="string", length=254, nullable=true)
     */
    private $job;

    /**
     * @var string|null
     *
     * @ORM\Column(name="resetPasswordUrl", type="string", length=254, nullable=true)
     */
    private $resetPasswordUrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="resetPasswordUrlDate", type="datetime", nullable=true)
     */
    private $resetPasswordUrlDate;

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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return null|string
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param null|string $roles
     */
    public function setRoles(?string $role): void
    {
        $this->roles[] = $role;
    }

    /**
     * @return null|string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param null|string $photo
     */
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return int|null
     */
    public function getNbcourses(): ?int
    {
        return $this->nbcourses;
    }

    /**
     * @param int|null $nbcourses
     */
    public function setNbcourses(?int $nbcourses): void
    {
        $this->nbcourses = $nbcourses;
    }

    /**
     * @return int|null
     */
    public function getNbcompletedcourses(): ?int
    {
        return $this->nbcompletedcourses;
    }

    /**
     * @param int|null $nbcompletedcourses
     */
    public function setNbcompletedcourses(?int $nbcompletedcourses): void
    {
        $this->nbcompletedcourses = $nbcompletedcourses;
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
    public function getJob(): ?string
    {
        return $this->job;
    }

    /**
     * @param null|string $job
     */
    public function setJob(?string $job): void
    {
        $this->job = $job;
    }

    /**
     * @return null|string
     */
    public function getResetPasswordUrl(): ?string
    {
        return $this->resetPasswordUrl;
    }

    /**
     * @param null|string $resetPasswordUrl
     */
    public function setResetPasswordUrl(?string $resetPasswordUrl): void
    {
        $this->resetPasswordUrl = $resetPasswordUrl;
    }

    /**
     * @return \DateTime|null
     */
    public function getResetPasswordUrlDate(): ?\DateTime
    {
        return $this->resetPasswordUrlDate;
    }

    /**
     * @param \DateTime|null $resetPasswordUrlDate
     */
    public function setResetPasswordUrlDate(?\DateTime $resetPasswordUrlDate): void
    {
        $this->resetPasswordUrlDate = $resetPasswordUrlDate;
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
     * Returns the salt that was originally used to hash the password.
     *
     * This can return null if the password was not hashed using a salt.
     *
     * This method is deprecated since Symfony 5.3, implement it from {@link LegacyPasswordAuthenticatedUserInterface} instead.
     *
     * @return string|null
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string
     *
     */
    public function getUserIdentifier()
    {
        return $this->getEmail();
    }

    /**
     * @return string
     *
     * @deprecated since Symfony 5.3, use getUserIdentifier() instead
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    public function __call($name, $arguments)
    {
        return $this->getEmail();
    }
}

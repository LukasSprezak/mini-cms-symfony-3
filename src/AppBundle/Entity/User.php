<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use AppBundle\Entity\Gallery\Gallery;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\{
    Common\Collections\ArrayCollection,
    ORM\Mapping as ORM
};
use Symfony\Component\{
    Validator\Constraints as Assert,
    Security\Core\User\UserInterface
};

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="This email is already use")
 * @UniqueEntity(fields="username", message="This username is already use")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=50,
     *     unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank()
     */
    private $plainPassword;

    /**
     * @ORM\Column(
     *     type="string",
     *     name="email",
     *     length=254,
     *     unique=true
     *     )
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=50
     *     )
     * @Assert\NotBlank()
     *
     */
    private $fullName;

    /**
     * @var Gallery[]|ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Gallery\Gallery",
     *     mappedBy="owner"
     * )
     * @ORM\JoinColumn(
     *     name="owner_id",
     *     referencedColumnName="id"
     * )
     */
    private $galleries;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    public function __construct()
    {
        $this->galleries = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles))
        {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {

    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getGalleries(): ArrayCollection
    {
        return $this->galleries;
    }

    public function addGalleries(Gallery $gallery): void
    {
        $this->galleries[] = $gallery;
    }

    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    public function unserialize($serialized): void
    {
        list($this->id,
            $this->username,
            $this->password) = unserialize($serialized);
    }
}

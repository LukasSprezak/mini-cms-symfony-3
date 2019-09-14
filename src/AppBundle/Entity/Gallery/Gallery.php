<?php
declare(strict_types=1);

namespace AppBundle\Entity\Gallery;

use AppBundle\Entity\User;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\{
    ArrayCollection,
    Collection
};
use Symfony\{
    Bridge\Doctrine\Validator\Constraints\UniqueEntity,
    Component\HttpFoundation\File\File};

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GalleryRepository")
 * @UniqueEntity(fields={"owner"})
 */

class Gallery
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(
     *     name="fullname",
     *     type="string",
     *     length=255
     *     )
     */
    private $fullname;

    /**
     * @var User
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\User",
     *     inversedBy="galleries"
     * )
     */
    private $owner;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     *     )
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(
     *     mapping="page_image",
     *     fileNameProperty="image"
     * )
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Gallery\Item",
     *     mappedBy="gallery",
     *     cascade={"persist"}
     *     )
     */
    private $item;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFullname(string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function addItem(Item $item): void
    {
        $this->item[] = $item;
        $item->setGallery($this);
    }

    public function removeItem(Item $item): void
    {
        $this->item->removeElement($item);
    }

    public function getItem(): Collection
    {
        return $this->item;
    }

    public function setImageFile(File $image = null): void
    {
        $this->imageFile = $image;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function __toString()
    {
        return (string) $this->owner;
    }
}


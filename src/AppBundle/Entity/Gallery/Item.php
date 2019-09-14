<?php
declare(strict_types=1);

namespace AppBundle\Entity\Gallery;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\{
    File\File,
    File\UploadedFile
};
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 */

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Item
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
     *     name="title",
     *     type="string",
     *     length=255,
     *     nullable=true
     *     )
     */
    private $title;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Gallery\Gallery",
     *     inversedBy="Item"
     * )
     * @ORM\JoinColumn(
     *     name="owner",
     *     referencedColumnName="id"
     * )
     */
    private $gallery;

    /**
     * @Vich\UploadableField(
     *     mapping="page_image",
     *     fileNameProperty="imageName"
     * )
     * @Assert\Type(type="Symfony\Component\HttpFoundation\File\UploadedFile")
     */
    private $imageFile;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     *)
     */
    private $imageName;

    /**
     * @ORM\Column(
     *     type="datetime",
     *     nullable=true
     *)
     * @var DateTime
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setGallery(Gallery $gallery = null)
    {
        $this->gallery = $gallery;
    }

    public function getGallery()
    {
        return $this->gallery;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param File|UploadedFile $image
     * @throws Exception
     */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            $this->updatedAt = new DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
}

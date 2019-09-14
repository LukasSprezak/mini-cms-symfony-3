<?php
declare(strict_types=1);

namespace AppBundle\Entity\Post;

use AppBundle\Entity\User;
use DateTime;
use Exception;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils\Slug;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\Common\Collections\{
    ArrayCollection,
    Collection
};
use Symfony\Component\HttpFoundation\File\{
    File,
    UploadedFile
};

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Post\PostRepository")
 * @ORM\Table(name="post_single")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields={"title"})
 * @UniqueEntity(fields={"slug"})
 */

class Post
{
    public const STATUS_PUBLISHED = "post.status_active";
    public const STATUS_UNPUBLISHED = "post.status_not_active";
    public const STATUS_DRAFT = "post.status_draft";

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     unique=true
     *)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max=255
     * )
     */
    private $title;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     unique=true
     *)
     * @Assert\Length(
     *      max=255
     * )
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $content;

    /**
     * @ORM\Column(
     *     name="status",
     *     type="string",
     *     length=10
     *)
     */
    private $status;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="AppBundle\Entity\Post\Category",
     *      inversedBy="posts"
     * )
     * @ORM\JoinColumn(
     *      name="category_id",
     *      referencedColumnName="id",
     *      onDelete="SET NULL"
     * )
     */
    private $category;

    /**
     * @ORM\ManyToMany(
     *      targetEntity="AppBundle\Entity\Post\Tag",
     *      inversedBy="posts"
     * )
     * @ORM\JoinTable(
     *      name="post_single_tags"
     * )
     * @Assert\Count(
     *      min=2
     * )
     */
    private $tags;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="AppBundle\Entity\User"
     * )
     * @ORM\JoinColumn(
     *      name="author_id",
     *      referencedColumnName="id"
     * )
     */
    private $author;

    /**
     * @ORM\Column(
     *     name="create_date",
     *     type="datetime"
     * )
     * @var DateTime
     */
    private $createDate;

    /**
     * @ORM\Column(
     *     name="published_date",
     *     type="datetime",
     *     nullable=true
     *)
     * @var DateTime
     * @Assert\DateTime
     */
    private $publishedDate;

    /**
     * @ORM\Column(
     *     name="update_date",
     *     type="datetime",
     *     nullable=true
     *)
     * @var DateTime
     */
    private $updateDate = null;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     *)
     * @Assert\Length(
     *      max=255
     * )
     */
    private $alt;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     *)
     * @Assert\Length(
     *      max=255
     * )
     */
    private $beginningText;

    /**
     * @ORM\Column(
     *     name="description",
     *     type="string",
     *     length=255,
     *     nullable=true
     *)
     * @Assert\Length(
     *      max=255
     * )
     */
    private $description;

    /**
     * @ORM\Column(
     *     name="keywords",
     *     type="string",
     *     length=255,
     *     nullable=true
     *)
     * @Assert\Length(
     *      max=255
     * )
     */
    private $keywords;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     name="hidden_sidebar"
     *)
     * @Assert\Length(
     *      max=255
     * )
     */
    protected $hiddenSidebar;

    /**
     * @Assert\NotBlank
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {
     *     "image/jpeg",
     *     "image/png"},
     *     mimeTypesMessage = "gallery.mime_type"
     * )
     * @Vich\UploadableField(
     *     mapping="blog_image",
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

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->hiddenSidebar = false;
        $this->createDate = new \DateTime();
        $this->publishedDate = new \DateTime();
        $this->updateDate = new \DateTime();
    }

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

    public function setSlug(string $slug): void
    {
        $this->slug = Slug::slugCreator($slug);
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function getCreateDate(): \DateTime
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTime $createDate): void
    {
        $this->createDate = $createDate;
    }

    public function setPublishedDate(\DateTime $publishedDate): void
    {
        $this->publishedDate = $publishedDate;
    }

    public function getPublishedDate(): \DateTime
    {
        return $this->publishedDate;
    }

    public function getUpdateDate(): \DateTime
    {
        return $this->updateDate;
    }

    public function setUpdateDate(\DateTime $updateDate): void
    {
        $this->updateDate = $updateDate;
    }


    public function setCategory(Category $category = null): void
    {
        $this->category = $category;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function addTag(Tag $tags): void
    {
        $this->tags[] = $tags;
    }

    public function removeTag(Tag $tags): void
    {
        $this->tags->removeElement($tags);
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): void
    {
        $this->alt = $alt;
    }

    public function getBeginningText(): ?string
    {
        return $this->beginningText;
    }

    public function setBeginningText(string $beginningText): void
    {
        $this->beginningText = $beginningText;
    }

    public function isHiddenSidebar(): bool
    {
        return $this->hiddenSidebar;
    }

    public function getHiddenSidebar(): ?bool
    {
        return $this->hiddenSidebar;
    }

    public function setHiddenSidebar(?bool $hiddenSidebar): void
    {
        $this->hiddenSidebar = $hiddenSidebar;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }

    /**
     * @param File|UploadedFile $image
     * @throws Exception
     */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            $this->updateDate = new DateTime();
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

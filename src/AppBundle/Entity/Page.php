<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use AppBundle\Utils\Slug;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 */
class Page
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(
     *     name="title",
     *     type="string",
     *     length=255,
     *     nullable=true
     *)
     * @Assert\Length(
     *     max=255
     *)
     */
    private $title;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @var string
     * @ORM\Column(
     *     name="description",
     *     type="string",
     *     length=255,
     *     nullable=true
     *     )
     * @Assert\Length(max=255)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(
     *     name="keywords",
     *     type="string",
     *     length=255,
     *     nullable=true
     *     )
     * @Assert\Length(max=255)
     */
    private $keywords;

    /**
     * @var string
     * @ORM\Column(
     *     name="content",
     *     type="text",
     *     nullable=true
     *     )
     */
    private $content;

    /**
     * @var \DateTime
     * @ORM\Column(
     *     name="createdAt",
     *     type="datetime"
     * )
     */
    private $createdAt;

    /**
     * @var bool
     * @ORM\Column(
     *     type="boolean",
     *     name="hidden_sidebar"
     * )
     */
    protected $hiddenSidebar;

    /**
     * @var string
     * @ORM\Column(
     *     name="alias",
     *     type="string",
     *     length=255,
     *     unique=true
     *     )
     * @Assert\NotBlank(
     *     message="page.not_blank"
     * )
     * @Assert\Length(
     *     max=255
     *)
     */
    private $alias;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->hiddenSidebar = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = $enabled;
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

    public function setAlias(string $alias): void
    {
        $this->alias = Slug::slugCreator($alias);
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }
}


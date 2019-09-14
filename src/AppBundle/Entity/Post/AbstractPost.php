<?php
declare(strict_types=1);

namespace AppBundle\Entity\Post;

use AppBundle\Utils\Slug;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\{
    Collections\ArrayCollection,
    Collections\Collection
};

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractPost
{
    
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
     */
    private $name;
    
    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     unique=true
     *)
     */
    private $slug;
    
    protected $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->name;
    }

    public function addPost(Post $posts): void
    {
        $this->posts[] = $posts;
    }

    public function removePost(Post $posts): void
    {
        $this->posts->removeElement($posts);
    }

    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = Slug::slugCreator($slug);
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave()
    {
        if(null === $this->slug){
            $this->setSlug($this->getName());
        }
    }
}

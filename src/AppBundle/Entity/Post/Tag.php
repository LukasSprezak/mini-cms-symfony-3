<?php
declare(strict_types=1);

namespace AppBundle\Entity\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Post\TagRepository")
 * @ORM\Table(name="post_tags")
 */
class Tag extends AbstractPost
{
    /**
     * @ORM\ManyToMany(
     *      targetEntity="AppBundle\Entity\Post\Post",
     *      mappedBy="tags"
     * )
     */
    protected $posts;
}

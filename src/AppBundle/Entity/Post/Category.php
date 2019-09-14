<?php
declare(strict_types=1);

namespace AppBundle\Entity\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Post\CategoryRepository")
 * @ORM\Table(name="post_category")
 */
class Category extends AbstractPost
{
    /**
     * @ORM\OneToMany(
     *      targetEntity="AppBundle\Entity\Post\Post",
     *      mappedBy="category"
     * )
     */
    protected $posts;
}

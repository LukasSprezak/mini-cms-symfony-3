<?php

declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Entity\Gallery\Gallery;

class GalleryRepository extends \Doctrine\ORM\EntityRepository
{
    public function viewGalleryImages(Gallery $gallery): array
    {
        return $this
            ->getEntityManager()
            ->createQuery(
                "SELECT i
                FROM AppBundle:Item i
                WHERE i.gallery = :gallery
                ORDER BY i.updatedAt ASC"
            )
            ->setParameter("gallery", $gallery)
            ->getResult()
            ;
    }

    public function countAmountGalleries(): array
    {
        return $this->createQueryBuilder("g")
            ->select("count(g.id) as countGalleries")
            ->getQuery()
            ->getResult()
            ;
    }
}
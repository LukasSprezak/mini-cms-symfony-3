<?php

declare(strict_types=1);

namespace AppBundle\Repository\Post;

use AppBundle\Entity\Post\Post;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class PostRepository extends EntityRepository
{
    public function createListQueryBuilder(array $params = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->select('p, c, t, a')
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.tags', 't')
            ->leftJoin('p.author', 'a');

        if (!empty($params['categorySelectedSlug'])){
            $queryBuilder
                ->andWhere('c.slug = :categorySelectedSlug')
                ->setParameter('categorySelectedSlug', $params['categorySelectedSlug'])
            ;
        }

        if (!empty($params['categorySelectedId'])) {
            if (-1 == $params['categorySelectedId']) {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->isNull('p.category'))
                ;
            } else {
                $queryBuilder
                    ->andWhere('c.id = :categorySelectedId')
                    ->setParameter('categorySelectedId', $params['categorySelectedId'])
                ;
            }
        }

        if (!empty($params['tagSlug'])) {
            $queryBuilder
                ->andWhere('t.slug = :tagSlug')
                ->setParameter('tagSlug', $params['tagSlug'])
            ;
        }
        return $queryBuilder;
    }

    public function findPublishedPost(string $slug)
    {
        return $this->createQueryBuilder("p")
            ->andWhere('p.slug = :slug')
            ->andWhere("p.status = :active")
            ->setParameter('slug', $slug)
            ->setParameter("active", Post::STATUS_PUBLISHED)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findActiveStatus(): array
    {
        return $this->createQueryBuilder("p")
            ->where("p.status = :active")
            ->setParameter("active", Post::STATUS_PUBLISHED)
            ->getQuery()
            ->getResult()
            ;
    }

    public function countAmountPosts(): array
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id) as countPosts')
            ->getQuery()
            ->getResult()
            ;
    }
}

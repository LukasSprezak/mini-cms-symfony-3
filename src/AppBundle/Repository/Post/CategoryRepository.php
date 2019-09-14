<?php

declare(strict_types=1);

namespace AppBundle\Repository\Post;

use Doctrine\ORM\QueryBuilder;

class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function createListQueryBuilder(array $params = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder
            ->select('c, COUNT(p.id) as postsCount')
            ->leftJoin('c.posts', 'p')
            ->groupBy('c.id')
        ;

        return $queryBuilder;
    }

    public function getCategoryToArray(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name')
            ->getQuery()
            ->getResult()
            ;
    }
}

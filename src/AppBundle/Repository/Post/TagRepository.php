<?php

declare(strict_types=1);

namespace AppBundle\Repository\Post;

use Doctrine\ORM\QueryBuilder;

class TagRepository extends \Doctrine\ORM\EntityRepository
{
    public function createListQueryBuilder(array $params = []): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('t');
        $queryBuilder
            ->select('t, COUNT(p.id) as postsCount')
            ->leftJoin('t.posts', 'p')
            ->groupBy('t.id')
        ;

        return $queryBuilder;
    }
}

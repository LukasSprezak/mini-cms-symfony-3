<?php

declare(strict_types=1);

namespace AppBundle\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function countAmountUsers(): array
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id) as countUsers')
            ->getQuery()
            ->getResult()
            ;
    }
}

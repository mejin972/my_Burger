<?php

namespace App\Repository;

use App\Entity\RangUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RangUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method RangUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method RangUser[]    findAll()
 * @method RangUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RangUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RangUser::class);
    }

    // /**
    //  * @return RangUser[] Returns an array of RangUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RangUser
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

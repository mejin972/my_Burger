<?php

namespace App\Repository;

use App\Entity\FavorisDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavorisDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavorisDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavorisDetail[]    findAll()
 * @method FavorisDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavorisDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavorisDetail::class);
    }

    // /**
    //  * @return FavorisDetail[] Returns an array of FavorisDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavorisDetail
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

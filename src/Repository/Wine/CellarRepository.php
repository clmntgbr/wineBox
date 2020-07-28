<?php

namespace App\Repository\Wine;

use App\Entity\Wine\Cellar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cellar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cellar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cellar[]    findAll()
 * @method Cellar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CellarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cellar::class);
    }

    // /**
    //  * @return Cellar[] Returns an array of Cellar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cellar
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

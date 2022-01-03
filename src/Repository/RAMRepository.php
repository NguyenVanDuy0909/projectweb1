<?php

namespace App\Repository;

use App\Entity\RAM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RAM|null find($id, $lockMode = null, $lockVersion = null)
 * @method RAM|null findOneBy(array $criteria, array $orderBy = null)
 * @method RAM[]    findAll()
 * @method RAM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RAMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RAM::class);
    }

    // /**
    //  * @return RAM[] Returns an array of RAM objects
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
    public function findOneBySomeField($value): ?RAM
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

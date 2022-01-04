<?php

namespace App\Repository;

use App\Entity\Laptop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Laptop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Laptop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Laptop[]    findAll()
 * @method Laptop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LaptopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Laptop::class);
    }

    /**
     * @return Laptop[] 
     */
    public function sortIdAsc()
    {
        return $this->createQueryBuilder('laptop')
            ->orderBy('laptop.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Laptop[] 
     */
    public function sortIdDesc()
    {
        return $this->createQueryBuilder('laptop')
            ->orderBy('laptop.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Laptop[]
     */
    public function searchLaptop($name)
    {
        return $this->createQueryBuilder('laptop')
            ->andWhere('laptop.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('laptop.name', 'asc')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Laptop[] Returns an array of Laptop objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Laptop
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

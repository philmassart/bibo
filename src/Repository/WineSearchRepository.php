<?php

namespace App\Repository;

use App\Entity\WineSearch;
use Doctrine\Persistence\ManagerRegistry as Registry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WineSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method WineSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method WineSearch[]    findAll()
 * @method WineSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WineSearchRepository extends ServiceEntityRepository
{
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, WineSearch::class);
    }

    // /**
    //  * @return WineSearch[] Returns an array of WineSearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WineSearch
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

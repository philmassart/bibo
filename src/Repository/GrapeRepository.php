<?php

namespace App\Repository;

use App\Entity\Grape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Grape|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grape|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grape[]    findAll()
 * @method Grape[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrapeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grape::class);
    }

    // /**
    //  * @return Grape[] Returns an array of Grape objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Grape
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

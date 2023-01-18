<?php

namespace App\Repository;

use App\Entity\Grape;
use Doctrine\Persistence\ManagerRegistry as Registry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Grape|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grape|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grape[]    findAll()
 * @method Grape[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrapeRepository extends ServiceEntityRepository
{
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, Grape::class);
    }

    /**
     * @return mixed
     */
    public function myFindAll()
    {
        return $this->myFindAllBuilder()
            ->getQuery()
            ->getResult();
    }

    public function myFindAllBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('g')
            ->select('g')
            ->orderBy('g.name', 'ASC');
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

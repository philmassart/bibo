<?php

namespace App\Repository;

use App\Entity\Container;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Container|null find($id, $lockMode = null, $lockVersion = null)
 * @method Container|null findOneBy(array $criteria, array $orderBy = null)
 * @method Container[]    findAll()
 * @method Container[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Container::class);
    }

    /**
     * @return mixed
     */
    public function myFindAllContainer()
    {
        return $this->myFindAllContainerBuilder()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function myFindAllContainerBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->orderBy('c.name', 'ASC');
    }

///*    /**
//    * @return Container[] Returns an array of Container objects
//    */
//
//    public function findByCapacity($value)
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.capacity = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->getQuery()
//            ->getResult()
//        ;
//    }*/


    /*
    public function findOneBySomeField($value): ?Container
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

<?php

namespace App\Repository;

use App\Entity\Appellation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Appellation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appellation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appellation[]    findAll()
 * @method Appellation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppellationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appellation::class);
    }

    /**
     * @return mixed
     */
    public function myFindAllAppel()
    {
        return $this->myFindAllAppelBuilder()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function myFindAllAppelBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->innerJoin('a.region', 'r')
            ->orderBy('r.name', 'ASC');
    }

    // /**
    //  * @return Appellation[] Returns an array of Appellation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appellation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

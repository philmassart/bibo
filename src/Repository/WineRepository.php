<?php

namespace App\Repository;

use App\Entity\Wine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Wine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wine[]    findAll()
 * @method Wine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wine::class);
    }



    /**
     * @return Wine[]
     */
    public function findAllVisible(): array
    {

        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
        
    }

    /**
     * @return Wine[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }



    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('w')
            ->where('w.stock = true');
    }
}


// /**
//  * @return Wine[] Returns an array of Wine objects
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
public function findOneBySomeField($value): ?Wine
{
    return $this->createQueryBuilder('w')
        ->andWhere('w.exampleField = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getOneOrNullResult()
    ;
}
*/
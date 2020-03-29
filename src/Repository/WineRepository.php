<?php

namespace App\Repository;

use App\Entity\Wine;
use App\Entity\WineSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
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
     * @param int $id
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id)
    {
        return $this->createQueryBuilder('w')
            ->select(['w', 'g'])
            ->leftJoin('w.grapes', 'g')
            ->orderBy('g.name', 'ASC')
            ->where('w.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Query
     */
    public function findAllVisibleQuery(WineSearch $search): Query
    {

        $query = $this->findVisibleQuery();

        if ($search->getMaxPrice()) {
            $query = $query
                ->andWhere('w.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getMinYear()) {
            $query = $query
                ->andWhere('w.year >= :minyear')
                ->setParameter('minyear', $search->getMinYear());
        }

        if ($search->getGrapes()->count() > 0) {
            $k = 0;
            foreach($search->getGrapes() as $grape) {
                $k++;
                $query = $query
                    ->andWhere(":grape$k MEMBER OF w.grapes")
                    ->setParameter("grape$k", $grape);
            }
        }


            return $query->getQuery();

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

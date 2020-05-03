<?php

namespace App\Repository;

use App\Entity\Feature;
use App\Entity\Grape;
use App\Entity\Pairing;
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
            $query
                ->andWhere('w.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getMinYear()) {
            $query
                ->andWhere('w.year >= :minyear')
                ->setParameter('minyear', $search->getMinYear());
        }

        if ($search->getGrapes()->count() > 0) {
            $i = 0;
            $whereOr = '(';
            /** @var Grape $grape */
            foreach ($search->getGrapes() as $grape) {
                $i++;
                $query
                    ->leftJoin('w.grapes', 'w_'.$i);
                $whereOr .= '(w_'.$i.'.id = '.$grape->getId().') OR ';
            }
            $query->andWhere(substr($whereOr, 0, -4).')');
        }

        if ($search->getFeatures()->count() > 0) {
            $i = 0;
            $whereOr = '(';
            /** @var Feature $feature */
            foreach ($search->getFeatures() as $feature) {
                $i++;
                $query
                    ->leftJoin('w.features', 'w_'.$i);
                $whereOr .= '(w_'.$i.'.id = '.$feature->getId().') OR ';
            }
            $query->andWhere(substr($whereOr, 0, -4).')');
        }

        if ($search->getPairings()->count() > 0) {
            $i = 0;
            $whereOr = '(';
            /** @var Pairing $pairing */
            foreach ($search->getPairings() as $pairing) {
                $i++;
                $query
                    ->leftJoin('w.pairings', 'w_'.$i);
                $whereOr .= '(w_'.$i.'.id = '.$pairing->getId().') OR ';
            }
            $query->andWhere(substr($whereOr, 0, -4).')');
        }

        if ($search->getAppellation()) {
            $query
                ->andWhere("w.appellation = :appellation")
                ->setParameter("appellation", $search->getAppellation());
        }

        if ($search->getColor()) {
            $query
                ->andWhere("w.color = :color")
                ->setParameter("color", $search->getColor());
        }


        if ($search->getWinegrowing()) {
            $query
                ->andWhere("w.winegrowing = :winegrowing")
                ->setParameter("winegrowing", $search->getWinegrowing());
        }

        if ($search->getName())
        {
            $query->andWhere("w.name LIKE '%".$search->getName()."%'");
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
        return $this->createQueryBuilder('w');
//            ->where('w.stock > 0');
    }


    public function myFindAllColorBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('w')
            ->select('w')
            ->orderBy('w.color', 'ASC');
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

    /**
     * @return QueryBuilder
     */
    public function myFindAllBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('w')
            ->select('w')
            ->orderBy('w.name', 'ASC');
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

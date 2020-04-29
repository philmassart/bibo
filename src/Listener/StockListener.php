<?php


namespace App\Listener;


use App\Entity\Stock;
use App\Entity\Wine;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;

class StockListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->countStock($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->countStock($args);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Stock)
        {
            return;
        }

        $em = $args->getEntityManager();
        /** @var Stock $stock */
        $stock = $entity;
        $wine = $stock->getWine();

        $actualStock = $wine->getStock();
        $wine->setStock($actualStock - $stock->getQuantity());
        $em->persist($wine);
    }

    private function countStock(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Stock)
        {
            return;
        }

        $em = $args->getEntityManager();
        /** @var Stock $stock */
        $stock = $entity;
        $wine = $stock->getWine();

        $actualStock = $wine->getStock();

        if ($stock->getMovement() == Stock::MOVEMENT['movement.in'])
        {
            $newStock = $actualStock + $stock->getQuantity() - $stock->getOldQuantity();
        }
        else
        {
            $newStock = $actualStock - $stock->getQuantity() + $stock->getOldQuantity();
        }

        $wine->setStock($newStock);

        $em->persist($wine);
    }

}
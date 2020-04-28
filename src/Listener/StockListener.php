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

    private function countStock(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if (!$entity instanceof Stock)
        {
            return;
        }

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
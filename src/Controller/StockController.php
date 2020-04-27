<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Wine;
use App\Form\StockType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class StockController extends AbstractController
{
    /**
     * @param Wine $wine
     * @param string $movement
     * @param Request $request
     * @return Response
     * @Route("/movement/{id}", name="stock.movement")
     */
    public function movement(Wine $wine, Request $request, EntityManagerInterface $entityManager)
    {
        $stock = new Stock();
        $stock->setWine($wine);
        $form = $this->createForm(StockType::class, $stock)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($stock->getMovement() == Stock::MOVEMENT['movement.in']) {
                $wine->setStock($wine->getStock()+$stock->getQuantity());
            }
            else {
                $wine->setStock($wine->getStock()-$stock->getQuantity());

            }
            $entityManager->persist($stock);
            $entityManager->persist($wine);
            $entityManager->flush();
            return $this->redirectToRoute('wine.show', [
                'id' => $wine->getId(),
                'slug' => $wine->getSlug()
            ]);
        }
        return $this->render("stock/movement.html.twig", [
            'form' => $form->createView()
        ]);

}


}

<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Wine;
use App\Form\StockType;
use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/movement")
 */
class StockController extends AbstractController
{
    /**
     * @param Wine $wine
     * @param string $movement
     * @param Request $request
     * @return Response
     * @Route("/{id}", name="stock.movement")
     */
    public function movement(Wine $wine, Request $request, EntityManagerInterface $entityManager)
    {
        $stock = new Stock();
        $stock->setWine($wine);
        $form = $this->createForm(StockType::class, $stock)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stock);
            $entityManager->flush();

            return $this->redirectToRoute('wine.show', [
                'id' => $wine->getId(),
                'slug' => $wine->getSlug()
            ]);
        }

        return $this->render("stock/movement.html.twig", [
            'form' => $form->createView(),
            'wine' => $wine
        ]);

    }

//    /**
//     * @Route("/", name="movement.index", methods={"GET"})
//     */
//    public function index(StockRepository $repository): Response
//    {
//        return $this->render('stock/index.html.twig', [
//            'id' => $repository->myFindAll(),
//        ]);
//    }

    /**
     * @param Wine $wine
     * @param Stock $stock
     * @param Request $request
     * @return Response
     * @Route("/{id}/edit", name="movement.edit", methods={"GET","POST"})
     */
    public function edit(Stock $stock, Request $request, EntityManagerInterface $entityManager): Response
    {
        $stock->setOldQuantity($stock->getQuantity());
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stock);
            $entityManager->flush();

            $wine=$stock->getWine();
            $entityManager->persist($wine);
            $entityManager->flush();

            return $this->redirectToRoute('wine.show',
                [
                'id' => $wine->getId(),
                'slug' => $wine->getSlug()
            ]
            );
        }

        return $this->render('stock/movement.html.twig', [
//            'stock' => $movement,
            'form' => $form->createView(),
            'wine' => $stock->getWine()

        ]);
    }

    /**
     * @param Wine $wine
     * @param Request $request
     * @param Stock $stock
     * @return Response
     * @Route("/{id}/delete", name="movement.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Stock $stock): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stock);
            $entityManager->flush();
        }

        $wine=$stock->getWine();
        return $this->redirectToRoute('wine.show',
            [
                'id' => $wine->getId(),
                'slug' => $wine->getSlug()
            ]
        );
    }

}

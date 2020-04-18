<?php

namespace App\Controller;

use App\Entity\Pairing;
use App\Form\PairingType;
use App\Repository\PairingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/pairing")
 */
class PairingController extends AbstractController
{
    /**
     * @Route("/", name="pairing.index", methods={"GET"})
     */
    public function index(PairingRepository $pairingRepository): Response
    {
        return $this->render('pairing/index.html.twig', [
            'pairings' => $pairingRepository->myFindAll(),
        ]);
    }

    /**
     * @Route("/new", name="pairing.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pairing = new Pairing();
        $form = $this->createForm(PairingType::class, $pairing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pairing);
            $entityManager->flush();

            return $this->redirectToRoute('pairing.index');
        }

        return $this->render('pairing/new.html.twig', [
            'pairing' => $pairing,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="pairing.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pairing $pairing): Response
    {
        $form = $this->createForm(PairingType::class, $pairing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pairing.index');
        }

        return $this->render('pairing/edit.html.twig', [
            'pairing' => $pairing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pairing.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pairing $pairing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pairing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pairing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pairing.index');
    }
}

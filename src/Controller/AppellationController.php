<?php

namespace App\Controller;

use App\Entity\Appellation;
use App\Form\AppellationType;
use App\Repository\AppellationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/appellation")
 */
class AppellationController extends AbstractController
{
    /**
     * @Route("/", name="appellation.index", methods={"GET"})
     */
    public function index(AppellationRepository $appellationRepository): Response
    {
        return $this->render('appellation/index.html.twig', [
            'appellation' => $appellationRepository->myFindAllAppel(),
        ]);
    }

    /**
     * @Route("/new", name="appellation.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $appellation = new Appellation();
        $form = $this->createForm(AppellationType::class, $appellation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appellation);
            $entityManager->flush();

            return $this->redirectToRoute('appellation.index');
        }

        return $this->render('appellation/new.html.twig', [
            'appellation' => $appellation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="appellation.show", methods={"GET"})
     */
    public function show(Appellation $appellation): Response
    {
        return $this->render('appellation/show.html.twig', [
            'appellation' => $appellation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="appellation.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Appellation $appellation): Response
    {
        $form = $this->createForm(AppellationType::class, $appellation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('appellation.index');
        }

        return $this->render('appellation/edit.html.twig', [
            'appellation' => $appellation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="appellation.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Appellation $appellation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $appellation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appellation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appellation.index');
    }
}

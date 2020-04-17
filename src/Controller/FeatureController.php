<?php

namespace App\Controller;

use App\Entity\Feature;
use App\Form\FeatureType;
use App\Repository\FeatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/feature")
 */
class FeatureController extends AbstractController
{
    /**
     * @Route("/", name="feature.index", methods={"GET"})
     */
    public function index(FeatureRepository $featureRepository): Response
    {
        return $this->render('feature/index.html.twig', [
            'features' => $featureRepository->myFindAll(),
        ]);
    }

    /**
     * @Route("/new", name="feature.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $feature = new Feature();
        $form = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feature);
            $entityManager->flush();

            return $this->redirectToRoute('feature.index');
        }

        return $this->render('feature/new.html.twig', [
            'feature' => $feature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="feature.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Feature $feature): Response
    {
        $form = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('feature.index');
        }

        return $this->render('feature/edit.html.twig', [
            'feature' => $feature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="feature.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Feature $feature): Response
    {
        if ($this->isCsrfTokenValid('delete'.$feature->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($feature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('feature.index');
    }
}

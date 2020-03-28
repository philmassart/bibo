<?php

namespace App\Controller\Admin;

use App\Entity\Grape;
use App\Form\GrapeType;
use App\Repository\GrapeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/grape")
 */
class AdminGrapeController extends AbstractController
{
    /**
     * @Route("/", name="admin.grape.index", methods={"GET"})
     */
    public function index(GrapeRepository $grapeRepository): Response
    {
        return $this->render('admin/grape/index.html.twig', [
            'grapes' => $grapeRepository->myFindAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.grape.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $grape = new Grape();
        $form = $this->createForm(GrapeType::class, $grape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grape);
            $entityManager->flush();

            return $this->redirectToRoute('admin.grape.index');
        }

        return $this->render('admin/grape/new.html.twig', [
            'grape' => $grape,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="admin.grape.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Grape $grape): Response
    {
        $form = $this->createForm(GrapeType::class, $grape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.grape.index');
        }

        return $this->render('admin/grape/edit.html.twig', [
            'grape' => $grape,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.grape.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Grape $grape): Response
    {
        if ($this->isCsrfTokenValid('admin/delete'.$grape->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grape);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.grape.index');
    }
}

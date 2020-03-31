<?php

namespace App\Controller;

use App\Entity\Container;
use App\Form\ContainerType;
use App\Repository\ContainerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/container")
 */
class ContainerController extends AbstractController
{
    /**
     * @Route("/", name="container.index", methods={"GET"})
     */
    public function index(ContainerRepository $containerRepository): Response
    {
        return $this->render('container/index.html.twig', [
            'containers' => $containerRepository->myFindAllContainer(),
        ]);
    }

    /**
     * @Route("/new", name="container.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $container = new Container();
        $form = $this->createForm(ContainerType::class, $container);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($container);
            $entityManager->flush();

            return $this->redirectToRoute('container.index');
        }

        return $this->render('container/new.html.twig', [
            'container' => $container,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="container.show", methods={"GET"})
     */
    public function show(Container $container): Response
    {
        return $this->render('container/show.html.twig', [
            'container' => $container,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="container.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Container $container): Response
    {
        $form = $this->createForm(ContainerType::class, $container);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('container.index');
        }

        return $this->render('container/edit.html.twig', [
            'container' => $container,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="container.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Container $container): Response
    {
        if ($this->isCsrfTokenValid('delete' . $container->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($container);
            $entityManager->flush();
        }

        return $this->redirectToRoute('container.index');
    }
}

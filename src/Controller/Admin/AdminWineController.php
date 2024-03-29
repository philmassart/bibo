<?php

namespace App\Controller\Admin;

use App\Entity\Wine;
use App\Form\WineType;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Traits\SoftDeleteable;
use Gedmo\Mapping\Annotation as Gedmo;


class AdminWineController extends AbstractController
{
    public function __construct(
        /**
         *
         */
        private readonly WineRepository $repository,
        private readonly EntityManagerInterface $em
    )
    {
    }

    /**
     * @Route("/admin", name="admin.wine.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $wines = $this->repository->myFindAll($this->getUser());
        return $this->render('admin/wine/index.html.twig', compact('wines'));
    }

    /**
     * @Route("/admin/wine/create", name="admin.wine.new")
     */
    public function new(Request $request)
    {
        $wine = new Wine();
        $wine->setUser($this->getUser());
        //$wine->setStock(0);

        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($wine);
            $this->em->flush();
            $this->addFlash('success', 'Créé avec succès');
            return $this->redirectToRoute('admin.wine.index');

        }

        return $this->render('admin/wine/new.html.twig', [
            'wine' => $wine,
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/admin/wine{id}", name="admin.wine.edit", methods="GET|POST")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Wine $wine, Request $request)
    {

        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succès');
            return $this->redirectToRoute('admin.wine.index');
        }

        return $this->render('admin/wine/edit.html.twig', [
            'wine' => $wine,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/wine/{id}", name="admin.wine.delete", methods="DELETE")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Wine $wine, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $wine->getID(), $request->get('_token'))) {
            $this->em->remove($wine);
            $this->em->flush();
            $this->addFlash('success', 'Supprimé avec succès');

        }

        return $this->redirectToRoute('admin.wine.index');
    }


}
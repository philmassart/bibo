<?php

namespace App\Controller;

use App\Repository\WineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param WineRepository $repository
     * @return Response
     */

    public function index(WineRepository $repository): Response
    {
        $wines = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'wines' => $wines
        ]);
    }
}
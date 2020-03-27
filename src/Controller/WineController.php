<?php
namespace App\Controller;

use App\Entity\Wine;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WineController extends AbstractController
{

    /**
     * @var WineRepository
     */
    private $repository;

    public function __construct(WineRepository $repository, EntityManagerInterface $em)
    {

        $this->repository = $repository;
    }

    /**
     * @Route("/vins", name="wine.index")
     * @return Response
     */
    public function index(): Response
    {
        $wines = $this->repository->findAllVisible();
        return $this->render('wine/index.html.twig', [
            'current_menu' => 'wines',
            'wines' => $wines
        ]);
    }

    /**
     * @Route("/vins/{slug}-{id}", name="wine.show", requirements={"slug": "[a-z0-9\-]*" })
     * @param Wine $wine
     * @return Response
     */
    public function show(Wine $wine, string $slug): Response
    {
        if ($wine->getSlug() !== $slug) {
            return $this->redirectToRoute('wine.show', [
                'id' => $wine->getId(),
                'slug' => $wine->getSlug()
            ], 301);
        }
        return $this->render('wine/show.html.twig', [
            'wine' => $wine,
        'current_menu' => 'wines'
    ]);
    }
}

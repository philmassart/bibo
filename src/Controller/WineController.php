<?php
namespace App\Controller;

use App\Entity\Wine;
use App\Entity\WineSearch;
use App\Form\WineSearchType;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new WineSearch();
        $form = $this->createForm(WineSearchType::class, $search)
            ->handleRequest($request);

        $wines = $paginator->paginate(
            $this->repository ->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
        12
      );
        return $this->render('wine/index.html.twig', [
            'current_menu' => 'wines',
            'wines' => $wines,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/vins/{slug}-{id}", name="wine.show", requirements={"slug": "[a-z0-9\-]*" })
     * @param Wine $wine
     * @return Response
     *
     * @ParamConverter(
     *     "wine",
     *     class="App\Entity\Wine",
     *     options={
     *         "repository_method" = "findOneById",
     *         "mapping": {"id": "id"},
     *         "map_method_signature" = true
     *     }
     * )
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

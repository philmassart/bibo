<?php
namespace App\Controller;
use App\Entity\Appellation;
use App\Entity\Wine;
use App\Entity\WineSearch;
use App\Form\WineSearchType;
use App\Repository\AppellationRepository;
use App\Repository\WineSearchRepository;
use App\Repository\RegionRepository;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Component\Serializer\Serializer;
use Twig\Environment;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
class WineController extends AbstractController
{
    /**
     * @var WineRepository
     */
    private $repository;
    private $twig;
    private $pdf;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(WineRepository $repository, EntityManagerInterface $em, Environment $twig, Pdf $pdf)
    {
        $this->repository = $repository;
        $this->twig = $twig;
        $this->pdf = $pdf;
        $this->em = $em;
    }

    /**
     * @Route("/wines", name="wine.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param WineSearchRepository $wineSearchRepository
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request, WineSearchRepository $wineSearchRepository): Response
    {
        $search = new WineSearch();
        $searchFinded = $wineSearchRepository->findOneById('1');
        if ($searchFinded)
        {
            $search = $searchFinded;
        }

        if ($request->getMethod() == 'POST')
        {
            $search->getGrapes()->clear();
            $search->getFeatures()->clear();
            $search->getPairings()->clear();
        }

        $form = $this->createForm(WineSearchType::class, $search, [
            "action" => $this->generateUrl('wine.index'),
            "method" => "POST",
            "attr" => [
                "id" > "wineSearch"
            ]
        ])
            ->handleRequest($request);

        if ($form->isSubmitted())
        {
            $this->em->persist($search);
            $this->em->flush();
        }

        $wines = $paginator->paginate(
            $this->repository->findAllVisibleQuery($this->getUser(), $search),
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
     * @Route("/wines/{slug}-{id}", name="wine.show", requirements={"slug": "[a-z0-9\-]*" })
     *
     * @param Wine $wine
     * @param string $slug
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
    /**
     * @Route("/listp", name="wine.list", methods={"GET"})
     */
    public function listp(RegionRepository $regionRepository): Response
    {
        $regions = $regionRepository->findBy([], ["name" => "ASC"]);
        $totalBottles = 0;
        $totalPrices = 0;
        foreach($regions as $region)
        {
            $totalBottles += $region->getTotalBottles();
            $totalPrices += $region->getTotalPrices(true);
        }
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Times');
//        $pdfOptions->set('isRemoteEnabled', true);
//        $pdfOptions->set('isHtml5ParserEnabled', true);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $regions = $regionRepository->findBy([], ["name" => "ASC"]);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('wine/snappy.html.twig',[
            'regions' => $regions,
            'totalBottles' => $totalBottles,
            'totalPrices' => $totalPrices
        ]);
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
    /**
     * @Route("/pdf", name="pdf")
     * @return Response
     */
    public function pdf(RegionRepository $regionRepository)
    {
        $regions = $regionRepository->findBy([], ["name" => "ASC"]);
        $totalBottles = 0;
        $totalPrices = 0;
        foreach($regions as $region)
        {
            $totalBottles += $region->getTotalBottles();
            $totalPrices += $region->getTotalPrices(true);
        }
        $html = $this->renderView('wine/snappy.html.twig', [
            'regions' => $regions,
            'totalBottles' => $totalBottles,
            'totalPrices' => $totalPrices
        ]);
        return new PdfResponse(
            $this->pdf->getOutputFromHtml($html),
            'liste.pdf',
            'application/pdf',
            'inline'
        );
    }
    /**
     * @Route("/stat", name="stat")
     * @return type
     */
    public function statregion()
    {
        $wine = $this->getDoctrine()->getRepository(Wine::class)->findAll();
        $nbregion = 0;
        foreach ($wine as $wine) {
            $nbregion += $wine->getTotalBottles();
        }
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Region', 'Number'],
                ['Alsace',    $nbregion ],
                ['Beaujolais',     0],
                ['Bordeaux',      15],
                ['Bourgogne',  25],
                ['Champagne', 3],
                ['Jura-Savoie',    18],
                ['Languedox-Roussillon',    0],
                ['Loire',    1],
                ['Provence-Corse',    0],
                ['Rhône',    5],
                ['Sud-Ouest',    1],
            ]
        );
        $pieChart->getOptions()->setTitle('Vins par région');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('wine/stat.html.twig', array('piechart' => $pieChart));
    }
}
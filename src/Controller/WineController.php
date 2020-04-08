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
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Twig\Environment;


class WineController extends AbstractController
{

    /**
     * @var WineRepository
     */
    private $repository;
    private $twig;
    private $pdf;

    public function __construct(WineRepository $repository, EntityManagerInterface $em, Environment $twig, Pdf $pdf)
    {

        $this->repository = $repository;
        $this->twig = $twig;
        $this->pdf = $pdf;
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
            $this->repository->findAllVisibleQuery($search),
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


    /**
     * @Route("/listp", name="wine_list", methods={"GET"})
     */
    public function listp(WineRepository $repository): Response
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $wines = $repository->findAll();



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('wine/listp.html.twig',[
            'wines' => $wines,
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
    public function pdfAction(WineRepository $repository)
    {
        $wines = $repository->findAll();

        $html = $this->renderView('wine/snappy.html.twig', [
           'wines' => $wines,
            ]);

        return new PdfResponse(
            $this->pdf->getOutputFromHtml($html),
            'liste.pdf',
            'application/pdf',
            'inline'
        );
    }





}

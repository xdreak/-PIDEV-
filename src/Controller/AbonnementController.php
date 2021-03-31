<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Abonnment;
use App\Repository\AbonnmentRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Session\Session;
class AbonnementController extends AbstractController
{
    /**
     * @Route("/abonnement", name="abonnement")
     */
    public function index(): Response
    {
        $abonnements=$this->getDoctrine()->getRepository(Abonnment::class)->findAll();
        return $this->render('abonnement/index.html.twig',array ('abonnements'=>$abonnements));
    }
    /**
     * @Route("/Frontend/mesAbonnements", name="mesAbonnements")
     */
    public function mesAbonnements(): Response
    {
        $session = new Session();
        $username=$session->get('username');
        $abonnements=$this->getDoctrine()->getRepository(Abonnment::class)->findAbonnmentBytitle($username);
        return $this->render('abonnement/mesAbonnements.html.twig',array ('abonnements'=>$abonnements));
    }
    /**
     * @Route("/pdf ", name="pdfOffre")
     */
    public function pdf(AbonnmentRepository $Repository)
    {
        $Abonnment = $Repository->findall();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('abonnement/pdf.html.twig', [
            'title' => "Welcome to our PDF Test",
            'Abonnement' => $Abonnment
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Offres De emploi.pdf", [
            "Attachment" => true
        ]);
    }
   
}

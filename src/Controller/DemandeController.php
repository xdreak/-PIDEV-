<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Offre;
use App\Form\DemandeType;
use App\Form\OffreType;
use App\Repository\DemandeRepository;
use App\Repository\OffreRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    /**
     * @Route("/Demandes/add/{id}", name="a")
     */
    public function ajouter(Request $request,$id,OffreRepository $repository)
    {
        $demande = new Demande();//creation instance
        $offre=$repository->find($id);
        $demande->setRelatedOffre($offre);
        $form = $this->createForm(DemandeType::class, $demande);//Récupération du formulaire dans le contrôleur:
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();//recupuration entity manager
            $em->persist($demande);//l'ajout de la objet cree
            $em->flush();
            return $this->redirectToRoute('ListeOffres');//redirecter la pagee la page dafichage
        }

        return $this->render('demande/index.html.twig', [
            'form' => $form->createview()
        ]);

    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


    /**
     * @Route("/AfficherDemande", name="afficheD")
     */
    public function liste()
    {
        $repository = $this->getDoctrine()->getrepository(Demande::Class);//recuperer repisotory
        $demandes = $repository->findAll();//affichage
        return $this->render('demande/Afficher.html.twig', [
            'demandes' => $demandes,
        ]);//liasion twig avec le controller
    }

    /**
     * @route ("offre/modifier/{id}", name="z")
     */
    function modifier(OffreRepository $repository,Request $request,$id)
    {
        $demandes=$repository->find($id);
        $form = $this->createForm(DemandeType::class, $demandes);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheD');
        }
        return $this->render('demande/modifD.html.twig',[
            'form'=>$form->createView()
        ]);


    }


    /**
     * @Route("/supp/{id}", name="f")
     */
    public function supprimer ($id)
    {
        $demandes=$this->getDoctrine()->getRepository(Demande::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($demandes);//suprrimer lobjet dans le parametre
        $em->flush();
        return $this->redirectToRoute('afficheD');

    }


    /**
     * @Route("/Demandes/find/{id}", name="z")
     */
    public function listeDemandes($id)
    {
        $repository = $this->getDoctrine()->getrepository(Demande::Class);//recuperer repisotory
        $demandes = $repository->findBy(
            ['RelatedOffre' => $id]
        );
        return $this->render('offre_emploi/demandes.html.twig', [
            'demandes' => $demandes,
        ]);//liasion twig avec le controller
    }

    /**
     * @Route("/pdfDemande ", name="pdfDemande")
     */
    public function pdf(DemandeRepository $Repository)
    {
        $Demande = $Repository->findall();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('offre_emploi/pdfD.html.twig', [
            'title' => "Welcome to our PDF Test",
            'Demande' => $Demande
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("les demande De emploi.pdf", [
            "Attachment" => true
        ]);
    }
}

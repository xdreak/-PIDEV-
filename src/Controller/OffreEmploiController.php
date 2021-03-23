<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;


class OffreEmploiController extends AbstractController
{

    /**
     * @Route("/AjoutOffre", name="Ajoute")
     */
    public function ajouter(Request $request)
    {
        $offre = new Offre();//creation instance
        $form = $this->createForm(OffreType::class, $offre);//Récupération du formulaire dans le contrôleur:
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid ()) {
            $em = $this->getDoctrine()->getManager();//recupuration entity manager
            $em->persist($offre);//l'ajout de la objet cree
            $em->flush();
            return $this->redirectToRoute('Affiche');//redirecter la pagee la page dafichage
        }

        return $this->render('Offre_emploi/index.html.twig', [
            'form' => $form->createview()
        ]);

    }

    /**
     * @Route("/AfficherOffres", name="Affiche")
     */
    public function liste()
    {
        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findAll();//affichage
        return $this->render('offre_emploi/Affiche.html.twig', [
            'offres' => $offres,
        ]);//liasion twig avec le controller
    }

    /**
     * @route ("offre/modifier/{id}", name="u")
     */
    function modifier(OffreRepository $repository,Request $request,$id)
    {
        $offre=$repository->find($id);
        $form = $this->createForm(OffreType::class, $offre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('Affiche');
        }
        return $this->render('offre_emploi/modif.html.twig',[
            'form'=>$form->createView()
        ]);


    }


    /**
     * @Route("offre/supp/{id}", name="remove")
     */
    public function supprimer ($id)
    {
        $offers=$this->getDoctrine()->getRepository(Offre::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($offers);//suprrimer lobjet dans le parametre
        $em->flush();
        return $this->redirectToRoute('afficheD');

    }

    /**
     * @route ("Offre/search", name="search")
     */
    function searchTitle(OffreRepository $repository,Request $request )
    {
        $data1=$request->get('find1');
        $data2=$request->get('find2');
        $offres=$repository->findBy(array('Title'=>$data1, 'Ville'=>$data2));
        return $this->render('offre_emploi/Affiche.html.twig',
            ['offres' => $offres]);

    }

    /**
     * @route ("Offre/Order", name="orderD")
     */
    function OrderSalD(OffreRepository $repository,Request $request )
    {

        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findBy(
            array(),
            array('Salaire' => 'DESC')
        );
        return $this->render('offre_emploi/Affiche.html.twig',
            ['offres' => $offres]);

    }

    /**
     * @route ("Offre/Orders", name="orderA")
     */
    function OrderSalAS(OffreRepository $repository,Request $request )
    {

        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findBy(
            array(),
            array('Salaire' => 'ASC')
        );
        return $this->render('offre_emploi/Affiche.html.twig',
            ['offres' => $offres]);

    }

    /**
     * @Route("/stats", name="stat")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findAll();//affichage
        return $this->render('offre_emploi/stats.html.twig', [
            'offres' => $offres,
        ]);//liasion twig avec le controller
    }



    /**
     * @Route("/pdf ", name="pdfOffre")
     */
    public function pdf(OffreRepository $Repository)
    {
        $Offre = $Repository->findall();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('offre_emploi/pdf.html.twig', [
            'title' => "Welcome to our PDF Test",
            'Offre' => $Offre
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

    /**
     *
     * @Route ("/mail/{id}", name="mail")
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function Mailing(\Swift_Mailer $mailer,$id,OffreRepository $Repository)
    {
        $repository = $this->getDoctrine()->getrepository(Offre::Class);
        $offres = $repository->findBy(
            ['id' => $id]
        );
        $message = (new \Swift_Message('Service Stages E-Mployini'))
            ->setFrom('marwen.khazri@esprit.tn')
            ->setTo('monialamia@hotmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'offre_emploi/mailO.html.twig',
                    ['offres' => $offres]
                ),
                'text/html'

            );

        $mailer->send($message);

        return $this->redirectToRoute('a',[
            'id' => $id
        ]);
    }


}



<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Offre;
use App\Entity\Quiz;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use App\Repository\QuizRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
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
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Recruteur") {
            return $this->redirectToRoute('redirect');
        }
        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findAll();//affichage
        return $this->render('offre_emploi/Affiche.html.twig', [
            'offres' => $offres,
            'session' => $session,
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
    public function supprimer ($id, QuizRepository $reps)
    {
        
        $offers=$this->getDoctrine()->getRepository(Offre::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($offers);//suprrimer lobjet dans le parametre
        $em->flush();
        return $this->redirectToRoute('Affiche');

    }



    /**
     * @route ("Offre/Order", name="orderD")
     */
    function OrderSalD(OffreRepository $repository,Request $request )
    {
       

        $repository = $this->getDoctrine()->getrepository(Offre::class);//recuperer repisotory
        $offres = $repository->findBy(
            array(),
            array('Salaire' => 'DESC')
        );
        return $this->render('offre_emploi/Affiche.html.twig',
            ['offres' => $offres,]);

    }

    /**
     * @route ("Offre/Orders", name="orderA")
     */
    function OrderSalAS(OffreRepository $repository,Request $request )
    {
        
        $repository = $this->getDoctrine()->getrepository(Offre::class);//recuperer repisotory
        $offres = $repository->findBy(
            array(),
            array('Salaire' => 'ASC')
        );
        return $this->render('offre_emploi/Affiche.html.twig',
            ['offres' => $offres,]);

    }

    /**
     * @Route("/stats", name="stat")
     */
    public function index(): Response
    {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Recruteur") {
            return $this->redirectToRoute('redirect');
        }
        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findAll();//affichage
        return $this->render('offre_emploi/stats.html.twig', [
            'offres' => $offres,
            'session' => $session,
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
        $session = new Session();
        $to=$session->get('email');
        $repository = $this->getDoctrine()->getrepository(Offre::Class);
        $offres = $repository->findBy(
            ['id' => $id]
        );
        $message = (new \Swift_Message('Service Stages E-Mployini'))
            ->setFrom('marwen.khazri@esprit.tn')
            ->setTo($to)
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

    /**
     * @Route("/SearchOffrex ", name="searchOffrex")
     */
    public function searchOffrex(Request $request,NormalizerInterface $Normalizer)
    {
        
        $repository = $this->getDoctrine()->getRepository(Offre::class);
        $requestString=$request->get('searchValue');
        $students = $repository->findOffreByVille($requestString);
        $jsonContent = $Normalizer->normalize($students, 'json',['groups'=>'marwen']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }

    /**
     * @Route("offre/QR/{id}", name="QR")
     */
    function QR(OffreRepository $repository,Request $request,$id)
    {
        
        $repository = $this->getDoctrine()->getrepository(Offre::class);//recuperer repisotory


        $offres = $repository->findBy(
            ['id' => $id]
        );
        return $this->render('offre_emploi/QR.html.twig', [
            'offres' => $offres,
            
        ]);//liasion twig avec le controller


    }


}



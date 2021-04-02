<?php

namespace App\Controller;

use App\Form\OffreStageType2;
use App\Repository\CandidatureStageRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CandidatureStageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use phpDocumentor\Reflection\Type;
use App\Entity\CandidatureStage;
use App\Entity\OffreStage;
use App\Form\OffreStageType;
use App\Repository\OffreStageRepository;
use App\Controller\QuizStageController;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

use Symfony\Component\HttpFoundation\Session\Session;




class Blog1Controller extends AbstractController
{
    /**
     * @Route("/Blog1", name="Blog1")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'Blog1Controller',
        ]);

    }


    /**
     * @param CandidatureStageRepository $Repository
     * @return Response
     * @Route ("/list", name="list")
     */
    public function list(CandidatureStageRepository $Repository)
    {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Recruteur") {
            return $this->redirectToRoute('redirect');
        }
        $CandidatureStage = $Repository->findall();
        return $this->render('candidaturestage/list.html.twig', [
            'CandidatureStage' => $CandidatureStage]);
    }

    /**
     * @param CandidatureStageRepository $Repository
     * @Route ("/liststages/" , name="liststages")
     */
    public function liststages(OffreStageRepository $Repository)
    {
        $order = 1;
        $OffreStage = $Repository->findall();
        return $this->render('candidaturestage/stages.html.twig', [
            'OffreStage' => $OffreStage,
            'order' => $order
        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/Quiz/" , name="Quiz")
     */
    public function Quiz()
    {
        return $this->render('candidaturestage/Quiz.html.twig');

    }

    /**
     * @Route ("/add/{id}", name="add")
     */


    public function add(Request $Request, OffreStageRepository $Repository, $id)
    { 
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Recruteur") {
            return $this->redirectToRoute('redirect');
        }
        //$OffreStage = $Repository->findall();
        $CandidatureStage = new CandidatureStage();
        $OffreStage = $Repository->find($id);
        $CandidatureStage->setIdStage($OffreStage);


        $form = $this->createForm(CandidatureStageType::class, $CandidatureStage);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($Request);


        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($CandidatureStage);
            $em->flush();
            return $this->redirectToRoute('list');

        }
        return $this->render('candidaturestage/add.html.twig',
            [
                'form' => $form->createView(),

                'OffreStage' => $OffreStage]);
    }


    /**
     * @param CandidatureStageRepository $Repository
     * @param CandidatureStageRepository $em
     * @param $id
     * @param Request $Request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/update/{id}", name="update")
     */
    public function update(CandidatureStageRepository $Repository, CandidatureStageRepository $em, $id, Request $Request)
    {
        $CandidatureStage = $em->find($id);
        $form = $this->createForm(CandidatureStageType::class, $CandidatureStage);
        $form->add('update', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('list');
        }
        return $this->render('candidaturestage/update.html.twig',
            ['form' => $form->createView()]);

    }

    /**
     * @param CandidatureStageRepository $Repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/delete/{id}" , name="delete")
     */
    public function delete(CandidatureStageRepository $Repository, $id)
    {
        $CandidatureStage = $Repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($CandidatureStage);
        $em->flush();
        return $this->redirectToRoute('list');


    }


    /**
     * @param OffreStageRepository $Repository
     * @return Response
     * @Route ("/listoffresstages", name="listoffresstages")
     */
    public function listoffre(OffreStageRepository $Repository)
    {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Recruteur") {
            return $this->redirectToRoute('redirect');
        }
        $OffreStage = $Repository->findall();
        return $this->render('offrestage/listoffre.html.twig', [
            'OffreStage' => $OffreStage]);
    }

    /*
    /**
     * @return Response
     * @route ("/add/part",name="candidature_form")
     */
    /*
    public function candidature():Response
    {
        return $this->render('candidaturestage/add.html.twig',[
            'controller_name' => 'blog1controller',
    ]);
    }
    */

    /**
     * @param Request $Request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/addoffresstages", name="addoffresstages")
     */
    public function addoffresstages(Request $Request)
    {

       
        $OffreStage = new OffreStage();
        $form = $this->createForm(OffreStageType::class, $OffreStage);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($OffreStage);
            $em->flush();
            return $this->redirectToRoute('listoffresstages');
        }
        return $this->render('offrestage/addoffre.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @param OffreStageRepository $Repository
     * @param OffreStageRepository $em
     * @param $id
     * @param Request $Request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateoffresstages/{id}", name="updateoffresstages")
     */
    public function updateoffresstages(OffreStageRepository $Repository, OffreStageRepository $em, $id, Request $Request)
    {
        $OffreStage = $em->find($id);
        $form = $this->createForm(OffreStageType2::class, $OffreStage);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listoffresstages');
        }
        return $this->render('offrestage/updateoffre.html.twig',
            ['form' => $form->createView()]);

    }

    /**
     * @param OffreStageRepository $Repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/deleteoffresstages/{id}" , name="deleteoffresstages")
     */
    public function deleteoffresstages(OffreStageRepository $Repository, $id)
    {
        $OffreStage = $Repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($OffreStage);
        $em->flush();
        return $this->redirectToRoute('listoffresstages');


    }



    /**
     *
     * @Route ("/mails/{id}", name="mails")
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function Mailing(\Swift_Mailer $mailer, $id, CandidatureStageRepository $Repository, OffreStageRepository $Stages)
    {
        $session = new Session();
        $to=$session->get('email');
        $repository = $this->getDoctrine()->getrepository(OffreStage::class);
        $offres = $repository->findBy(
            ['id' => $id]
        );

        $message = (new \Swift_Message('Service Stages E-Mployini'))
            ->setFrom('E-Mployini@gmail.com')
            ->setTo($to);
      //  $img = $message->embed(\Swift_Image::fromPath('images/offre.png'));
        $message->setBody(
            $this->renderView(
            // templates/emails/registration.html.twig
                'offrestage/mail.html.twig',
                ['offres' => $offres,
                   /* 'img' => $img*/]
            ),
            'text/html'

        );



        $mailer->send($message);

        return $this->redirectToRoute('add', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/searchstage", name="searchstage")
     */
    public function searchStageajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(OffreStage::class);
        $requestString = $request->get('searchValue');

        $plan = $repository->findStageByEntreprise($requestString);


        return $this->render('candidaturestage/stageajax.html.twig', [
            'OffreStage' => $plan,
        ]);

    }

    /**
     * @Route("/pdfstage ", name="pdfstage")
     */
    public function pdf(OffreStageRepository $Repository)
    {
        $OffreStage = $Repository->findall();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('offrestage/pdf.html.twig', [
            'title' => "Welcome to our PDF Test",
            'OffreStage' => $OffreStage
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Offres De Stages.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @route ("Offre/search", name="search")
     */
    function searchTitle(OffreStageRepository $repository, Request $request)
    {
        $data = $request->get('find');
        $OffreStage = $repository->findBy(['NomEntreprise' => $data]);
        return $this->render('candidaturestage/stages.html.twig',
            ['OffreStage' => $OffreStage]);

    }

    /**
     * @route ("Offre/Order", name="orderD")
     */
    function OrderSalD(OffreStageRepository $repository, Request $request)
    {

        $repository = $this->getDoctrine()->getrepository(OffreStage::Class);//recuperer repisotory
        $OffreStage = $repository->findBy(
            array(),
            array('NomEntreprise' => 'DESC')
        );
        return $this->render('candidaturestage/stages.html.twig',
            ['OffreStage' => $OffreStage]);


    }

    /**
     * @route ("Offre/Orders", name="orderA")
     */
    function OrderSalAS(OffreStageRepository $repository, Request $request)
    {

        $repository = $this->getDoctrine()->getrepository(OffreStage::class);//recuperer repisotory
        $OffreStage = $repository->findBy(
            array(),
            array('NomEntreprise' => 'ASC')
        );
        return $this->render('candidaturestage/stages.html.twig',
            ['OffreStage' => $OffreStage]);

    }

    /**
     * @Route("Offresstages/OrderASC", name="croissant")
     */
    public function orderSujetASC(OffreStageRepository $repository)
    {
        $order = 2;
        $offresstages = $repository->triOffresStagesASC();
        return $this->render('candidaturestage/stages.html.twig', [
            'OffreStage' => $offresstages,
            'order' => $order
        ]);
    }

    /**
     * @Route("Offresstages/OrderDESC", name="decroissant")
     */
    public function orderSujetDESC(OffreStageRepository $repository)
    {
        $order = 1;
        $offresstages = $repository->triOffresStagesDESC();
        return $this->render('candidaturestage/stages.html.twig', [
            'OffreStage' => $offresstages,
            'order' => $order
        ]);
    }
    /**
     * @Route("/pdfqr ", name="pdfqr")
     */
    public function pdfqr(OffreStageRepository $Repository)
    {
        $OffreStage = $Repository->findall();
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('offrestage/qrcodedownload.html.twig', [
            'title' => "Welcome to our PDF Test",
            'offres' => $OffreStage
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("QRCode.pdf", [
            "Attachment" => true
        ]);
    }
}






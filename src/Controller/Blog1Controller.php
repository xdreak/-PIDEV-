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
use App\Controller\QuizController;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


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
        $CandidatureStage = $Repository->findall();
        return $this->render('candidaturestage/list.html.twig', [
            'CandidatureStage' => $CandidatureStage]);
    }

    /**
     * @param CandidatureStageRepository $Repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/liststages/" , name="liststages")
     */
    public function liststages(OffreStageRepository $Repository)
    {
        $OffreStage = $Repository->findall();
        return $this->render('candidaturestage/stages.html.twig', [
            'OffreStage' => $OffreStage]);
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
     * @Route ("/listoffre", name="listoffre")
     */
    public function listoffre(OffreStageRepository $Repository)
    {
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
     * @Route ("/addoffre", name="addoffre")
     */
    public function addoffre(Request $Request)
    {


        $OffreStage = new OffreStage();
        $form = $this->createForm(OffreStageType::class, $OffreStage);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($OffreStage);
            $em->flush();
            return $this->redirectToRoute('listoffre');
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
     * @Route ("/updateoffre/{id}", name="updateoffre")
     */
    public function updateoffre(OffreStageRepository $Repository,OffreStageRepository $em, $id,Request $Request)
    {
        $OffreStage = $em->find($id);
        $form = $this->createForm(OffreStageType2::class, $OffreStage);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listoffre');
        }
        return $this->render('offrestage/updateoffre.html.twig',
            ['form' => $form->createView()]);

    }

    /**
     * @param OffreStageRepository $Repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/deleteoffre/{id}" , name="deleteoffre")
     */
    public function deleteoffre(OffreStageRepository $Repository, $id)
    {
        $OffreStage = $Repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($OffreStage);
        $em->flush();
        return $this->redirectToRoute('listoffre');


    }

    /**
     *
     * @Route ("/mail/{test}", name="mail")
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function Mailing(\Swift_Mailer $mailer,$test)
    {

        $message = (new \Swift_Message('Service Stages E-Mployini'))
            ->setFrom('E-Mployini@gmail.com')
            ->setTo('imotemri@gmail.com')
        ->setBody(
        $this->renderView(
        // templates/emails/registration.html.twig
            'offrestage/mail.html.twig',
             ['test' => $test]
        ),
        'text/html'

        );

        $mailer->send($message);

        return $this->render('/offrestage/mail.html.twig',[
        'test' => $test
        ]);
    }
/*
    /**
     * @Route("/searchOffreStage ", name="ajaxsearch")
     */
/*
    public function searchOffreajax(Request $request,NormalizerInterface $Normalizer,OffreStageRepository $repository)
    {
        $repository = $this->getDoctrine()->getRepository(OffreStage::class);
        $requestString=$request->get('searchValue');
        $offres = $repository->findOffrebyname($requestString);

        return $this->render('offrestage/recherche.html.twig', [
            "offres" => $offres
            ]);

    }
*/

    /**
     * @Route("/searchstagex ", name="searchstagex")
     */
    public function searchStagex(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(OffreStage::class);
        $requestString=$request->get('searchValue');
        $offresstages = $repository->findStageByStageId($requestString);
        $jsonContent = $Normalizer->normalize($offresstages, 'json',['groups'=>'offresstages']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }


}

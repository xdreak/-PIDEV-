<?php

namespace App\Controller;

use App\Entity\OffreStage;
use App\Entity\Quiz2;
use App\Form\Quiz2Type;
use App\Form\Quiz4Type;
use App\Repository\OffreStageRepository;
use App\Repository\Quiz2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * @Route("/quizstage")
 */
class QuizStageController extends AbstractController
{
    /**
     * @Route("/", name="quiz_index", methods={"GET"})
     */
    public function index(Quiz2Repository $quizRepository): Response
    {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Recruteur") {
            return $this->redirectToRoute('redirect');
        }
        return $this->render('quiz2/index.html.twig', [
            'quizzes' => $quizRepository->findAll(),
        ]);
    }
    /**
     *
     * @Route("/new2/{id}", name="quiz_new2", methods={"GET","POST"})
     *
     */
    public function quiz2(Request $request, Quiz2 $quiz,OffreStageRepository $repository): Response
    {
        //$OffreStage=$repository->find($StageId);
        //$quiz->setIdStageQ($OffreStage);

        $form = $this->createForm(Quiz2Type::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();


            // return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz2/newfront.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/new", name="quiz_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quiz = new Quiz2();
        $form = $this->createForm(Quiz2Type::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quiz);
            $entityManager->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz2/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quiz_show", methods={"GET"})
     */
    public function show(Quiz2 $quiz): Response
    {
        return $this->render('quiz2/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="quiz_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quiz2 $quiz): Response
    {
        $form = $this->createForm(Quiz2Type::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quiz_index');
        }

        return $this->render('quiz2/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quiz_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Quiz2 $quiz): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quiz_index');
    }
    /**
     * @Route("/trouver/{id}", name="trouver")
     */
    public function Valider(Request $request,$id,OffreStageRepository $repositorys)
    {
        $repository = $this->getDoctrine()->getrepository(Quiz2::class);//recuperer repisotory
        $offre=$repositorys->find($id);
        $quizs = $repository->findBy(
            ['Id_StageQ'=> $id]
        );
        return $this->render('quiz2/reponse.html.twig', [
            'quizs' => $quizs,
        ]);//liasion twig avec le controller
    }
    /**
     * @Route("/trouver2/{id}", name="trouver2")
     */
    public function Correct(Request $request,$id,Quiz2Repository $repositorys)
    {

        $repository = $this->getDoctrine()->getrepository(OffreStage::class);//recuperer repisotory


        $offres = $repository->findBy(
            ['finder' => $id]
        );
        return $this->render('offrestage/congrats.html.twig', [
            'offres' => $offres,
        ]);//liasion twig avec le controller

    }

}

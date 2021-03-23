<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Offre;
use App\Entity\Quiz;
use App\Form\DemandeType;
use App\Form\OffreType;
use App\Form\QuizType;
use App\Repository\OffreRepository;
use App\Repository\QuizRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    /**
     * @Route("/AjoutQuiz", name="AjouterQ")
     */
    public function ajouter(Request $request)
    {
        $quiz = new Quiz();//creation instance
        $form = $this->createForm(QuizType::class, $quiz);//Récupération du formulaire dans le contrôleur:
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid ()) {
            $em = $this->getDoctrine()->getManager();//recupuration entity manager
            $em->persist($quiz);//l'ajout de la objet cree
            $em->flush();
            return $this->redirectToRoute('AfficheQ');//redirecter la pagee la page dafichage
        }

        return $this->render('quiz/AddQuiz.html.twig', [
            'form' => $form->createview()
        ]);

    }

    /**
     * @Route("/AfficherQuiz", name="AfficheQ")
     */
    public function AfficherQuizs()
    {
        $repository = $this->getDoctrine()->getrepository(Quiz::Class);//recuperer repisotory
        $quizs = $repository->findAll();//affichage
        return $this->render('quiz/index.html.twig', [
            'quizs' => $quizs,
        ]);//liasion twig avec le controller
    }

    /**
     * @Route("/Quizs/trouver/{id}", name="m")
     */
    public function Valider(Request $request,$id,OffreRepository $repositorys)
    {
        $repository = $this->getDoctrine()->getrepository(Quiz::Class);//recuperer repisotory
        $offre=$repositorys->find($id);
        $num=$offre->getTest();
        $quizs = $repository->findBy(
            ['finder' => $id]
        );
        return $this->render('quiz/valider.html.twig', [
            'quizs' => $quizs,
        ]);//liasion twig avec le controller
    }


    /**
     * @route ("quiz/modify/{id}", name="s")
     */
    function editQ(QuizRepository $repository,Request $request,$id)
    {
        $quiz=$repository->find($id);
        $form = $this->createForm(QuizType::class, $quiz);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheQ');
        }
        return $this->render('quiz/editQ.html.twig',[
            'form'=>$form->createView()
        ]);


    }

    /**
     * @Route("/supp/{id}", name="w")
     */
    public function supprimer ($id)
    {
        $quiz=$this->getDoctrine()->getRepository(Quiz::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($quiz);//suprrimer lobjet dans le parametre
        $em->flush();
        return $this->redirectToRoute('AfficheQ');

    }




}

<?php

namespace App\Controller;


use App\Entity\Offre;
use App\Entity\Quiz;
use App\Repository\OffreRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffresController extends AbstractController
{

    /**
     * @Route("/offres", name="ListeOffres")
     */
    public function liste()
    {
        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findAll();//affichage
        return $this->render('offres/index.html.twig', [
            'offres' => $offres,
        ]);//liasion twig avec le controller
    }


    /**
     * @Route("\offres\trouver\{id}", name="k")
     */
    public function Correct(Request $request,$id,QuizRepository $repositorys)
    {

        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory


        $offres = $repository->findBy(
            ['Test' => $id]
        );
        return $this->render('offres/congrats.html.twig', [
            'offres' => $offres,
        ]);//liasion twig avec le controller

    }
}

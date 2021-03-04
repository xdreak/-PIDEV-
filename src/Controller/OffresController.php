<?php

namespace App\Controller;


use App\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}

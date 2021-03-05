<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Abonnment;

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
   
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CareerFController extends AbstractController
{
    /**
     * @Route("/career/f", name="career_f")
     */
    public function index(): Response
    {
        return $this->render('career_f/index.html.twig', [
            'controller_name' => 'CareerFController',
        ]);
    }
    /**
     * @Route("/career/cv", name="career_cv")
     */
    public function cv(): Response
    {
        return $this->render('career_f/cv.html.twig', [
            'controller_name' => 'CareerFController',
        ]);
    }
    /**
     * @Route("/career/lm", name="career_lm")
     */
    public function lettreM(): Response
    {
        return $this->render('career_f/lettremotiv.html.twig', [
            'controller_name' => 'CareerFController',
        ]);
    }
    /**
     * @Route("/career/lr", name="career_lr")
     */
    public function lettreR(): Response
    {
        return $this->render('career_f/lettrerec.html.twig', [
            'controller_name' => 'CareerFController',
        ]);
    }
}

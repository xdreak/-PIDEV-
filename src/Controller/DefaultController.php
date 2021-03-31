<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Admin") {
            return $this->redirectToRoute('redirect');
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'session' => $session,
        ]);
    }
    /**
     * @Route("/Frontend", name="front")
     */
    public function indef(): Response
    {
        return $this->render('default/indef.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

}

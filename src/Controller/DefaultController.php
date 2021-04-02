<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Formation;
use App\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
 /**
     * @Route("/home", name="home")
     */
    public function index1(): Response
    {
   

        return $this->render('default/indef.html.twig', [
            'controller_name' => 'DefaultController'
        ]);
    }

    /**
     * @Route("/default", name="default")
     */
    public function index(): Response
    {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') == "Admin") {
            return $this->redirectToRoute('/user');
        }
        if($session->get('role') == "Recruteur") {
            return $this->redirectToRoute('/listoffresstages');
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
     /**
     * @Route("/dashboard", name="dashboard")
     */
    public function indexx(): Response
    
    {  
      
        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findAll();
        $repository = $this->getDoctrine()->getrepository(Category::class);//recuperer repository
        $Categorys = $repository->findAll();
        $CategoryId = $repository->countIds();
  
           foreach($CategoryId as $key => $value){
            foreach($value as $key1 => $value1){
            $repository1 = $this->getDoctrine()->getrepository(Formation::class);//recuperer repository
            $count[] = $repository1->countFormation($value1);
            }
           }
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController','offres'=> $offres,  'formations' => $Categorys,'categories'=>$count
        ]);
    }



}

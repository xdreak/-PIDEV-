<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Formation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
class FormationController extends AbstractController
{

     /**
     * @Route("/formation",name="formation")
     * @Method({"GET"})
     */
    public function index(): Response
    {
     $formations=$this->getDoctrine()->getRepository(Formation::class)->findAll();
     return $this->render('formation/index.html.twig',array ('formations'=>$formations));

    }
    

     /**
     * @Route("/addFormation")
     * @Method({"GET","POST"})
     */
    public function save(Request $request)
    {
        $classe=new Formation();
        $form=$this->createFormBuilder($classe)
        ->add('Titre', TextareaType::class, array(
        'label' => 'Titre',
          'required' => true,
          'attr' => array('class' => 'form-control')
        ))
             ->add('Date', DateType::class, array(
                'label' => 'Date',
                  'required' => true,
                  'attr' => array('class' => 'form-control')
         ))
         ->add('Lieu', TextareaType::class, array(
            'label' => 'Lieu',
              'required' => true,
              'attr' => array('class' => 'form-control')
        ))
        ->add('Description', TextareaType::class, array(
            'label' => 'Description',
              'required' => true,
              'attr' => array('class' => 'form-control')
        ))
        ->add('Prix', TextareaType::class, array(
            'label' => 'Prix',
              'required' => true,
              'attr' => array('class' => 'form-control')
        ))
        ->add('save', SubmitType::class, array(
          'label' => 'Ajouter',
          'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
          $classe = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($classe);
          $entityManager->flush();
  
          return $this->redirectToRoute('formation');
        }
        return $this->render('formation/addFormation.html.twig',array('form'=>$form->createView()));

    }





}

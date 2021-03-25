<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Formation;
use App\Entity\Abonnment;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FormationController extends AbstractController
{

  public function index(): Response
    {
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }
     /**
     * @Route("/formation",name="formation")
     * @Method({"GET"})
     */
    public function index1(): Response
    {
     $formations=$this->getDoctrine()->getRepository(Formation::class)->findAll();
     return $this->render('formation/index.html.twig',array ('formations'=>$formations));

    }
      /**
     * @Route("/formationFront",name="formationFront")
     * @Method({"GET"})
     */
    public function index2(): Response
    {
     $formations=$this->getDoctrine()->getRepository(Formation::class)->findAll();
     return $this->render('formation/index2.html.twig',array ('formations'=>$formations));

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
                'label' => 'DateDebut',
                  'required' => true,
                  'attr' => array('class' => 'form-control')

         ))
         ->add('DateFin', DateType::class, array(
          'label' => 'DateFin',
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
        ->add('category', EntityType::class,['class'=>Category::class,
        'choice_label'=>'titre',
        'label'=>'Catégorie'])
        ->add('save', SubmitType::class, array(
          'label' => 'Ajouter',
          'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        ->getForm();
        $form->handleRequest($request);
        $Date = $form->get('Date')->getData();
        $DateFin = $form->get('DateFin')->getData();

        if($form->isSubmitted() && $form->isValid()) {
          if($Date>$DateFin){
            $this->addFlash('fail', 'Vérifier la date fin! ');
 
          }
          $classe = $form->getData();
          
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($classe);
          $entityManager->flush();
          $this->addFlash('success', 'Formation Ajouté! ');
         
        }
        return $this->render('formation/addFormation.html.twig',array('form'=>$form->createView()));

    }
    /**
     * @Route("/formation/modifier/{id}", name="edit_class")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
      $Formation = new Formation();
      $Formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

      $form = $this->createFormBuilder($Formation)
      ->add('Titre', TextareaType::class, array(
        'label' => 'Titre',
          'required' => true,
          'attr' => array('class' => 'form-control')
        ))
             ->add('Date', DateType::class, array(
                'label' => 'Date',
                  'required' => true,
                  
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
          'label' => 'Modifier',
          'attr' => array('class' => 'btn btn-primary mt-3')
        ))
        
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('formation');
      }

      return $this->render('formation/modFormation.html.twig', array(
        'form' => $form->createView()
      ));
    }
 /**
     * @Route("/formation/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id,MailerInterface $mailer) {
      $Formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($Formation);
      $entityManager->flush();

      $response = new Response();
      $response->send();
      $titre=$Formation->getTitre();
     
      $members=$this->getDoctrine()->getRepository(User::class)->findAll();
        foreach ($members as $member) {
            $to = $member->getEmail();  
       
            $email = (new Email())
            ->from('gabsijihen33@gmail.com')
            ->to($to)
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Bonjour!')
            ->text("Une nouvelle: formation {$titre} a été annulé! ")
            ->html("<h1>Une nouvelle: formation {$titre} a été annulé! </h1><br><p>Nous somme vraiment désolé!</p>");
      
             $mailer->send($email);
            }
      return $this->redirectToRoute('formation');
    
  }
    

/**
     * @Route("/formation/afficher/{id}")
     */
    public function show($id) {
      $Formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

      return $this->render('formation/affichFormation.html.twig', array('formation' => $Formation));
    }

/**
     * @Route("/formation1/{titre}")
     */
    public function inscrire($titre,MailerInterface $mailer) {
      $entityManager = $this->getDoctrine()->getManager();

      $abonnement = new Abonnment();
      $abonnement->setNomUser('Jihen');
      $abonnement->setTitreFormation($titre);
      $abonnement->setStatue('paiment en cour');

     
      $entityManager->persist($abonnement);
      $email = (new Email())
      ->from('gabsijihen33@gmail.com')
      ->to('gabsijihen31@gmail.com')
      //->cc('cc@example.com')
      //->bcc('bcc@example.com')
      //->replyTo('fabien@example.com')
      //->priority(Email::PRIORITY_HIGH)
      ->subject('Bonjour!')
      ->text("Vous ètes inscrit a la formation:{$titre}!")
      ->html("<h1>Vous ètes inscrit a la formation:{$titre}</h1><br><p>Merci pour nous faire confiance!</p>");

  $mailer->send($email);
      
      $entityManager->flush();

      return $this->redirectToRoute('formationFront');
    }

    /**
     * @Route("Frontend/formation/{id}", name="formation_show")
     */
    public function show2($id) {
      $Formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

      return $this->render('formation/affichFormation2.html.twig', array('formation' => $Formation));
    }
    /**
     * @Route("/stats", name="stat")
     */
    public function stats(): Response
    {
        $repository = $this->getDoctrine()->getrepository(Abonnment::class);//recuperer repisotory
        $formations = $repository->findAll();
        // $repository1 = $this->getDoctrine()->getrepository(Abonnment::class);//recuperer repisotory
        // $abonnements = $repository1->();
        //affichage
        return $this->render('formation/statistics.html.twig', [
            'formations' => $formations,
        ]);//liasion twig avec le controller
    }


}

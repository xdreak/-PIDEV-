<?php

namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface; 
use App\Repository\CategoryRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;
use App\Entity\Abonnment;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints\Length;

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
    public function index2(Request $request,PaginatorInterface $paginator): Response
    {
     $donnees=$this->getDoctrine()->getRepository(Formation::class)->findAll();
     $formations = $paginator->paginate(
      $donnees, // Requête contenant les données à paginer (ici nos articles)
      $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
      4// Nombre de résultats par page
  );
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
          return $this->redirectToRoute('formation');
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
    public function stats()
    {
      $repository = $this->getDoctrine()->getrepository(Category::class);//recuperer repository
      $Categorys = $repository->findAll();
      $CategoryId = $repository->countIds();

         foreach($CategoryId as $key => $value){
          foreach($value as $key1 => $value1){
          $repository1 = $this->getDoctrine()->getrepository(Formation::class);//recuperer repository
          $count[] = $repository1->countFormation($value1);
          }
         }
        
       
      
   
        // $repository1 = $this->getDoctrine()->getrepository(Abonnment::class);//recuperer repository
        // $abonnements = $repository1->();
        //affichage
        return $this->render('formation/statistics.html.twig', [
            'formations' => $Categorys,'categories'=>$count
        ]);//liasion twig avec le controller
    }
    /**
     * @Route("/SearchFormation ", name="searchFormation")
     */
    public function searchFormation(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Formation::class);
        $requestString=$request->get('searchValue');
        $Formation = $repository->findFormationBytitle($requestString);
        $jsonContent = $Normalizer->normalize($Formation, 'json',['groups'=>'jihen']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }





  //      /**
  //    * @Route("/Search ")
  //    */
  //   public function searchAction(Request $request)
  //   {
  //       $em = $this->getDoctrine()->getManager();
  //       $requestString = $request->get('q');
  //       $formations =  $em->getrepository(Formation::class)->findFormationBytitle($requestString);
  //       if(!$formations) {
  //           $result['formations']['error'] = "Post Not found :( ";
  //       } else {
  //           $result['formations'] = $this->getRealEntities($formations);
  //       }
  //       return new Response(json_decode($result));
  //   }
  //   public function getRealEntities($formations){
  //     foreach ($formations as $formation){
  //         $realEntities[$formation->getId()] = [$formation->getTitre()];
  //     }
  //     return $realEntities;
  // }

}

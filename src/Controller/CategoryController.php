<?php

namespace App\Controller;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class CategoryController extends AbstractController
{
    
    /**
     * @Route("/category", name="category")
     * @Method({"GET"})
     */
    public function index(): Response
    {
    $categories=$this->getDoctrine()->getRepository(Category::class)->findAll();
     return $this->render('category/index.html.twig',array ('categories'=>$categories));
    }
      /**
     * @Route("/addCategory")
     * @Method({"GET","POST"})
     */
    public function save(Request $request)
    {
        $classe=new Category();
        $form=$this->createFormBuilder($classe)
        ->add('Titre', TextareaType::class, array(
        'label' => 'Titre',
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
          return $this->redirectToRoute('category');
        }
        return $this->render('category/addCategory.html.twig',array('form'=>$form->createView()));

    }
    /**
     * @Route("/category/modifier/{id}")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $Category = new Category();
        $Category = $this->getDoctrine()->getRepository(Category::class)->find($id);
  
        $form = $this->createFormBuilder($Category)
        ->add('Titre', TextareaType::class, array(
          'label' => 'Titre',
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
  
          return $this->redirectToRoute('category');
        }
  
        return $this->render('category/modCategory.html.twig', array(
          'form' => $form->createView()
        ));
      }
   /**
       * @Route("/category/delete/{id}")
       * @Method({"DELETE"})
       */
      public function delete(Request $request, $id) {
        $Category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Category);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('category');
      }
}

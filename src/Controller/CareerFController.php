<?php

namespace App\Controller;

use App\Entity\Articlelike;
use App\Entity\Artiles;
use App\Form\ArticleFormType;
use App\Repository\ArticlelikeRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CareerFController extends AbstractController
{
////////////////////////////////////////////LOGIN////////////////////////////////////
/// ////////////////////////////////////////////////////////////////////////////////
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('Carriere/security.html.twig');
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }

///////////////////////////Partie Admin///////////////////////////////////////////////
//Gestion Article////////////////////////////////////////////////////////////////////


    /**
     * @Route("/GestionCarriere", name="gestionCarriereAdmin")
     * @param Request $request
     * @param PaginatorInterface
     * @return Response
     */
    public function AfficherGestionConseilCarriere(Request $request ,PaginatorInterface $paginator): Response
    {
        $rep=$this->getDoctrine()->getRepository(Artiles::class)->findAll();
        $articles=$paginator->paginate(
            $rep,
            $request->query->getInt('page',1),4
        );
        return $this->render('Carriere/GestionCarriereAdmin.html.twig',[
            'articles'=>$articles,
            'paginator'=>$paginator,
        ]);
    }

    /**
     * @Route("/AjoutArtcile",name="AjoutArticle")
     * @Method({"GET", "POST"})
     */
    public function AjoutArticle(Artiles $article=null, Request $request, EntityManagerInterface $manager)
    {
        if(!$article){
            $article = new Artiles();
        }
        $form = $this->createFormBuilder($article)
            ->add('titre')
            ->add('resume')
            ->add('contenu',CKEditorType::class)
            ->add('imageFile',VichImageType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setPubliele(new DateTime());
            }
            $article=$form->getData();
            $manager->persist($article);
            $manager->flush();
            $this->addFlash("message","Article bien Ajouté");
            return $this->redirectToRoute('AfficherUnArticle',['id'=>$article->getId()]);
        }
        return $this->render('Carriere/AjoutArticleAdmin.html.twig',['formArticle'=> $form->createView()]);
    }

    /**
     * @Route("/Article/{id}", name="AfficherUnArticle")
     */
    public function AfficherUnArticleAdmin($id)
    {
        $rep=$this->getDoctrine()->getRepository(Artiles::class);
        $article=$rep->find($id);
        return $this->render('Carriere/AffUnArticleAdmin.html.twig',[
            'article'=>$article
        ]);
    }
    /**
     * @Route ("/Article/{id}/Modifier", name="ModifierArticle")
     */
    public function ModifierArticleAdmin(Artiles $article, Request $request,EntityManagerInterface $manager):Response
    {
        $formArticle=$this->createForm(ArticleFormType::class,$article);
        $formArticle->handleRequest($request);
        if($formArticle->isSubmitted() && $formArticle->isValid()){
            if($article->getId()){
                $article->setMajle(new DateTime());
            }
            $article=$formArticle->getData();
            $manager->persist($article);
            $manager->flush();
            $this->addFlash("message","Article bien Modifié");
            return $this->redirectToRoute('AfficherUnArticle',['id'=>$article->getId()]);
        }
        return $this->render('Carriere/ModifierArticle.html.twig',[
            'formArticle'=>$formArticle->createView()
        ]);
    }
    /**
     * @Route ("/Article/{id}/Supp", name="SupprimerArticle")
     */
    public function SupprimerArticle(Artiles $article): RedirectResponse
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('gestionCarriereAdmin');
    }




////////////////////////////////////////////Partie Client///////////////////////////
//Gestion Article//////////////////////////////////////////////////////////////////

    /**
     * @Route("/Articles", name="articlesClient")
     * @param Request $request
     * @param PaginatorInterface
     * @return Response
     */
    public function AfficheArticlesClient(Request $request ,PaginatorInterface $paginator): Response
    {
        $rep=$this->getDoctrine()->getRepository(Artiles::class)->findAll();
        $article=$paginator->paginate(
            $rep,
            $request->query->getInt('page',1),6
        );
        return $this->render('Carriere/ArticlesClient.html.twig', [
            'articles' => $article,
            'paginator'=>$paginator,
        ]);
    }
    /**
     * @Route("/CV", name="career_cv")
     */
    public function cv(): Response
    {
        return $this->render('Carriere/cv.html.twig', [
            'controller_name' => 'CareerFController',
        ]);
    }
    /**
     * @Route("/LettreM", name="career_lm")
     */
    public function lettreM(): Response
    {
        return $this->render('Carriere/lettremotiv.html.twig', [
            'controller_name' => 'CareerFController',
        ]);
    }

    /**
     * @Route("/ArticleN/{id}", name="AfficheUnArticleClient")
     */
    public function AfficheUnArticleClient($id)
    {
        $rep=$this->getDoctrine()->getRepository(Artiles::class);
        $article=$rep->find($id);
        return $this->render('Carriere/AffUnArticleClient.html.twig',[
            'article'=>$article
        ]);
    }

    /**
     * @Route("/post/{id}/like", name="post_like")
     */
    public function like(Artiles $post, ArticlelikeRepository $likeRepo)
    {
        $manager=$this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($post->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy(['post' => $post, 'user' => $user]);
            $manager->remove($like);
            $manager->flush();
            return $this->json(['code' => 200, 'likes' => $likeRepo->getCountForPost($post)], 200);
        }
        $like = new Articlelike();
        $like->setArticle($post)
            ->setUser($user);
        $manager->persist($like);
        $manager->flush();
        return $this->json(['code' => 200, 'likes' => $likeRepo->getCountForPost($post)], 200);
    }


}

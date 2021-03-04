<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreEmploiController extends AbstractController
{

    /**
     * @Route("/AjoutOffre", name="Ajoute")
     */
    public function ajouter(Request $request)
    {
        $offre = new Offre();//creation instance
        $form = $this->createForm(OffreType::class, $offre);//Récupération du formulaire dans le contrôleur:
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();//recupuration entity manager
            $em->persist($offre);//l'ajout de la objet cree
            $em->flush();
            return $this->redirectToRoute('Affiche');//redirecter la pagee la page dafichage
        }

        return $this->render('Offre_emploi/index.html.twig', [
            'form' => $form->createview()
        ]);

    }

    /**
     * @Route("/AfficherOffres", name="Affiche")
     */
    public function liste()
    {
        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory
        $offres = $repository->findAll();//affichage
        return $this->render('offre_emploi/Affiche.html.twig', [
            'offres' => $offres,
        ]);//liasion twig avec le controller
    }

    /**
     * @route ("offre/modifier/{id}", name="u")
     */
    function modifier(OffreRepository $repository,Request $request,$id)
    {
        $offre=$repository->find($id);
        $form = $this->createForm(OffreType::class, $offre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('Affiche');
        }
        return $this->render('offre_emploi/modif.html.twig',[
            'form'=>$form->createView()
        ]);


    }


    /**
     * @Route("/supp/{id}", name="d")
     */
    public function supprimer ($id)
    {
        $offre=$this->getDoctrine()->getRepository(Offre::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($offre);//suprrimer lobjet dans le parametre
        $em->flush();
        return $this->redirectToRoute('Affiche');

    }


}



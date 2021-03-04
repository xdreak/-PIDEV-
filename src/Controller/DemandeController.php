<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Offre;
use App\Form\DemandeType;
use App\Form\OffreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    /**
     * @Route("/AjoutDemande", name="Ajouter")
     */
    public function ajouter(Request $request)
    {
        $demande = new Demande();//creation instance
        $form = $this->createForm(DemandeType::class, $demande);//Récupération du formulaire dans le contrôleur:
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();//recupuration entity manager
            $em->persist($demande);//l'ajout de la objet cree
            $em->flush();
            return $this->redirectToRoute('ListeOffres');//redirecter la pagee la page dafichage
        }

        return $this->render('demande/index.html.twig', [
            'form' => $form->createview()
        ]);

    }
}

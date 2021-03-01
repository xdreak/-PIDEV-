<?php

namespace App\Controller;

use App\Repository\CandidatureStageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CandidatureStageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use phpDocumentor\Reflection\Type;
use App\Entity\CandidatureStage;
use App\Entity\OffreStage;
use App\Form\OffreStageType;
use App\Repository\OffreStageRepository;



class Blog1Controller extends AbstractController
{
    /**
     * @Route("/blog1", name="blog1")
     */
    public function index(): Response
    {
        return $this->render('blog1/index.html.twig', [
            'controller_name' => 'Blog1Controller',
        ]);

    }

    /**
     * @param CandidatureStageRepository $Repository
     * @return Response
     * @Route ("/list", name="list")
     */
    public function list(CandidatureStageRepository $Repository)
    {
        $CandidatureStage = $Repository->findall();
        return $this->render('blog1/list.html.twig', [
            'CandidatureStage' => $CandidatureStage]);
    }

    /**
     * @param Request $Request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/add", name="add")
     */


    public function add(Request $Request)
    {
        $CandidatureStage = new CandidatureStage();
        $form = $this->createForm(CandidatureStageType::class, $CandidatureStage);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($CandidatureStage);
            $em->flush();
            return $this->redirectToRoute('list');
        }
        return $this->render('blog1/add.html.twig',
            ['form' => $form->createView()]);
    }


    /**
     * @param CandidatureStageRepository $Repository
     * @param CandidatureStageRepository $em
     * @param $id
     * @param Request $Request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/update/{id}", name="update")
     */
    public function update(CandidatureStageRepository $Repository, CandidatureStageRepository $em, $id, Request $Request)
    {
        $CandidatureStage = $em->find($id);
        $form = $this->createForm(CandidatureStageType::class, $CandidatureStage);
        $form->add('update', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('list');
        }
        return $this->render('blog1/update.html.twig',
            ['form' => $form->createView()]);

    }
    /**
     * @param CandidatureStageRepository $Repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/delete/{id}" , name="delete")
     */
    public function delete(CandidatureStageRepository $Repository, $id)
    {
        $CandidatureStage = $Repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($CandidatureStage);
        $em->flush();
        return $this->redirectToRoute('list');


    }

    /**
     * @param OffreStageRepository $Repository
     * @return Response
     * @Route ("/listoffre", name="listoffre")
     */
    public function listoffre(OffreStageRepository $Repository)
    {
        $OffreStage = $Repository->findall();
        return $this->render('blog1/listoffre.html.twig', [
            'OffreStage' => $OffreStage]);
    }

    /**
     * @param Request $Request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/addoffre", name="addoffre")
     */
    public function addoffre(Request $Request)
    {
        $OffreStage = new OffreStage();
        $form = $this->createForm(OffreStageType::class, $OffreStage);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($OffreStage);
            $em->flush();
            return $this->redirectToRoute('listoffre');
        }
        return $this->render('blog1/addoffre.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @param OffreStageRepository $Repository
     * @param OffreStageRepository $em
     * @param $id
     * @param Request $Request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateoffre/{id}", name="updateoffre")
     */
    public function updateoffre(OffreStageRepository $Repository,OffreStageRepository $em, $id,Request $Request)
    {
        $OffreStage = $em->find($id);
        $form = $this->createForm(OffreStageType::class, $OffreStage);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listoffre');
        }
        return $this->render('blog1/updateoffre.html.twig',
            ['form' => $form->createView()]);

    }

    /**
     * @param OffreStageRepository $Repository
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/deleteoffre/{id}" , name="deleteoffre")
     */
    public function deleteoffre(OffreStageRepository $Repository, $id)
    {
        $OffreStage = $Repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($OffreStage);
        $em->flush();
        return $this->redirectToRoute('listoffre');


    }

}

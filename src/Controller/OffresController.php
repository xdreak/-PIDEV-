<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Offre;
use App\Entity\Quiz;
use App\Repository\OffreRepository;
use App\Repository\QuizRepository;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Exception\PageNumberOutOfRangeException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class OffresController extends AbstractController
{

    /**
     * @Route("/offres", name="ListeOffres")
     */
    public function liste(Request $request, PaginatorInterface $paginator): Response
    {
        $rep = $this->getDoctrine()->getRepository(Offre::class)->findAll();
        $offres = $paginator->paginate(
            $rep,
            $request->query->getInt('page', 1), 2
        );
        return $this->render('offres/index.html.twig', [
            'offres' => $offres,
            'paginator' => $paginator,
        ]);
    }


    /**
     * @Route("\offres\trouver\{id}", name="k")
     */
    public function Correct(Request $request,$id,QuizRepository $repositorys)
    {

        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory


        $offres = $repository->findBy(
            ['Test' => $id]
        );
        return $this->render('offres/congrats.html.twig', [
            'offres' => $offres,
        ]);//liasion twig avec le controller

    }

    /**
     * @Route("offre/details/{id}", name="Details")
     */
    function QR(OffreRepository $repository,Request $request,$id)
    {
        $repository = $this->getDoctrine()->getrepository(Offre::Class);//recuperer repisotory


        $offres = $repository->findBy(
            ['id' => $id]
        );
        return $this->render('offres/details.html.twig', [
            'offres' => $offres,
        ]);//liasion twig avec le controller

    }

    /**
     * @Route("/SearchOffreFrontx ", name="SearchOffreFrontx")
     */
    public function searchOffreFrontx(Request $request,NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Offre::class);
        $requestString=$request->get('searchValue');
        $students = $repository->findOffreByTitle($requestString);
        $jsonContent = $Normalizer->normalize($students, 'json',['groups'=>'marwen']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }

}

<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Admin") {
            return $this->redirectToRoute('redirect');
        }
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Profile::class)->findAll();
        return $this->render('profile/index.html.twig', [
            'profiles' => $tab,
            'session' => $session,
        ]);
    }


    public function delete($id)
    {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Admin") {
            return $this->redirectToRoute('redirect');
        }

        $em =$this->getDoctrine()->getManager();
        $profile = $em->getRepository(Profile::class)->find($id);
        $em->remove($profile);
        $em->flush();
        return $this->redirectToRoute('profile');
    }

    public function update(Request $request, $id)
    {
        $session = $request->getSession();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Admin") {
            return $this->redirectToRoute('redirect');
        }

        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository(Profile::class)->find($id);
        $form = $this->createForm(ProfileType::class,$profile);
        $form->add('user', EntityType::class,array('class'=>User::class,'choice_label'=>'username','multiple'=>false));
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/update.html.twig', [
            'form' => $form->createView(),
            'session' => $session,
        ]);
    }

//     public function addprofile(Request $request)
//     {
//         $session = $request->getSession();
//         if(!$session->has('role')) {
//             return $this->redirectToRoute('loginBack');
//         }
//         if($session->get('role') != "Admin") {
//             return $this->redirectToRoute('redirect');
//         }

//         $profile = new Profile();
//         $em = $this->getDoctrine()->getManager();
//         $users=$em->getRepository(User::class)->usersWithNoProfile();
       
//         if($request->isMethod("POST"))
//         {
//             $profile->setNom((string)$request->request->get("nom"));
//             $profile->setPrenom((string)$request->request->get("prenom"));
//             $profile->setMobile((string)$request->request->get("mobile"));
//             $profile->setAge((string)$request->request->get("age"));
//             $profile->setVille((string)$request->request->get("ville"));
//             $id = (string)$request->request->get("user");

//             //echo "".$id;
//             $user = $em->getRepository(User::class)->find($id);
//             $profile->setUser($user);

//             $em->persist($profile);
//             $em->flush();
//             //return $this->redirectToRoute('profile');
//         }

//         return $this->render('profile/addprofile.html.twig', [
//             'lUsers' => $users,
//             'session' => $session,
//         ]);
//     }

//     /**
//      * @Route("/d1a5eaa", name="searchProfile")
//      */
//     public function search(Request $request) {
//         $em=$this->getDoctrine()->getManager();
//         $tab=$em->getRepository(Profile::class)->search($request->get('input'));
//         return $this->render('profile/index.html.twig', [
//             'profiles' => $tab,
//             'session' => $request->getSession(),
//         ]);
//     }
}
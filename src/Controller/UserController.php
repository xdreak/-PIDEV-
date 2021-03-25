<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
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
        $tab=$em->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $tab,
            'session' => $session,
        ]);
    }

    public function adduser(Request $request)
    {
        $session = $request->getSession();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Admin") {
            return $this->redirectToRoute('redirect');
        }

        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {   $classroom = $form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($classroom);
            $profile = new Profile();
            $profile->setUser($user);
            $em->persist($profile);
            $em->flush();
            return $this->redirectToRoute('user');
        }

        return $this->render('user/adduser.html.twig', [
            'form' => $form->createView(),
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
        $user = $em->getRepository(User::class)->find($id);
        $profile = $em->getRepository(Profile::class)->findOneBy(['user' => $id]);
        $em->remove($profile);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user');
    }

    public function update(Request $request,$id)
    {
        $session = $request->getSession();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Admin") {
            return $this->redirectToRoute('redirect');
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class,$user);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('user');
        }

        return $this->render('user/update.html.twig', [
            'form' => $form->createView(),
            'session' => $session,
        ]);

    }

    /**
     * @Route("/login", name="loginBack")
     */
    public function login(Request $request) {
        $session = $request->getSession();
        if($session->has('role')) {
            return $this->redirectToRoute('redirect');
        }
        if($request->isMethod("POST")) {

            $username = (string) $request->request->get("username");
            $password = (string) $request->request->get("password");
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy([
                'username' => $username,
                'password' => $password
            ]);
            //echo $user->getRole();
           if ( isset($user)) {
               $session->set('id', $user->getId());
               $session->set('username', $user->getUsername());
               $session->set('password', $user->getPassword());
               $session->set('email', $user->getEmail());
               $session->set('role', $user->getRole());
               $profile = $em->getRepository(Profile::class)->findOneBy(['user' => $user]);
               $session->set('idProfile', $profile->getId());
               $session->set('nom', $profile->getNom());
               $session->set('prenom', $profile->getPrenom());
               $session->set('mobile', $profile->getMobile());
               $session->set('age', $profile->getAge());
               $session->set('ville', $profile->getVille());

               return $this->redirectToRoute('redirect');
            }
        }

        return $this->render('user/login.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        $session = new Session();
        $session->remove('id');
        $session->remove('username');
        $session->remove('password');
        $session->remove('email');
        $session->remove('role');
        $session->remove('idProfile');
        $session->remove('nom');
        $session->remove('prenom');
        $session->remove('mobile');
        $session->remove('age');
        $session->remove('ville');
        $session->invalidate();

        return $this->redirectToRoute('loginBack');
    }

    /**
     * @Route("/candidat", name="candidat")
     */
    public function testCandidat() {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Candidat") {
            return $this->redirectToRoute('redirect');
        }
        return $this->render('user/testCandidat.html.twig', [
            'session' => $session,
        ]);
    }

    /**
     * @Route("/recruteur", name="recruteur")
     */
    public function testRecruteur() {
        $session = new Session();
        if(!$session->has('role')) {
            return $this->redirectToRoute('loginBack');
        }
        if($session->get('role') != "Recruteur") {
            return $this->redirectToRoute('redirect');
        }

        return $this->render('user/testRecruteur.html.twig', [
            'session' => $session,
        ]);
    }

    // /**
    //  * @Route("/da94sd5c", name="searchUser")
    //  */
    // public function search(Request $request) {
    //     $em=$this->getDoctrine();
    //     $tab=$em->getRepository(User::class)->search($request->get('input'));
    //     return $this->render('user/index.html.twig', [
    //         'users' => $tab,
    //         'session' => $request->getSession(),
    //     ]);
    // }

    /**
     * @Route("/redirect", name="redirect")
     */
    public function redirectUser() {
        $session = new Session();
        $role = $session->get('role');
        if($role == "Admin") {
            return $this->redirectToRoute('default');
        }
        elseif($role == "Candidat") {
            return $this->redirectToRoute('candidat');
        }
        elseif($role == "Recruteur") {
            return $this->redirectToRoute('recruteur');
        }
        else {
            return $this->redirectToRoute('logout');
        }
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request) {
        $session = $request->getSession();
        if($session->has('role')) {
            return $this->redirectToRoute('redirect');
        }

        if($request->isMethod("POST")) {
            $em = $this->getDoctrine()->getManager();

            $user = new User();
            $user->setUsername($request->request->get('username'));
            $user->setPassword($request->request->get('password'));
            $user->setEmail($request->request->get('email'));
            $user->setRole('Candidat');
            $em->persist($user);

            $profile = new Profile();
            $profile->setUser($user);
            $profile->setNom($request->request->get('nom'));
            $profile->setPrenom($request->request->get('prenom'));
            $profile->setMobile($request->request->get('mobile'));
            $profile->setAge($request->request->get('age'));
            $profile->setVille($request->request->get('ville'));
            $em->persist($profile);

            $em->flush();

            //session
            $session->set('id', $user->getId());
            $session->set('username', $user->getUsername());
            $session->set('password', $user->getPassword());
            $session->set('email', $user->getEmail());
            $session->set('role', $user->getRole());
            $session->set('idProfile', $profile->getId());
            $session->set('nom', $profile->getNom());
            $session->set('prenom', $profile->getPrenom());
            $session->set('mobile', $profile->getMobile());
            $session->set('age', $profile->getAge());
            $session->set('ville', $profile->getVille());

            return $this->redirectToRoute('redirect');
        }

        return $this->render('user/registration.html.twig');
    }

    /**
     * @Route("/forgetPassword", name="forgetPassword")
     */
    public function forgetPassword(MailerInterface $mailer, Request $request) {
        $em = $this->getDoctrine()->getManager();
        if($request->request->has('password')) {
            $password = $request->request->get('password');
            $code = $request->request->get('code');
            $inputCode = $request->request->get('inputcode');
            $id = $request->request->get('id');
            if($code == $inputCode) {
                $user = $em->getRepository(User::class)->find($id);
                $user->setPassword($password);
                $em->flush();
                return $this->redirectToRoute('loginBack');
            }
            return $this->redirectToRoute('loginBack');
        }
        $email = $request->request->get('email');
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if(isset($user)) {
            $code = rand(111111, 999999);
            $email = (new Email())
                ->from('ITeam@esprit.tn')
                ->to($email)
                ->subject('Forget Password!')
                ->text('Code: '.$code)
                ->html('<p>Code: '.$code.'</p>');

            $mailer->send($email);

            return $this->render('user/forgetPassword.html.twig', [
                'user' => $user,
                'code' => $code,
            ]);
        }

    }

}

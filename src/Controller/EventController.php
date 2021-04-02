<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Event;
use App\Entity\EventParticipations;
use App\Entity\User;
use App\Form\EventFormType;
use App\Repository\EventParticipationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
class EventController extends AbstractController
{




/////////////////////////////////////////////partie Client/////////////////////////////////////

    /**
     * @Route("/Events", name="MapEvent")
     */
    public function AfficheMapEvent()
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $events=$rep->findAll();
        return $this->render('event/MapEvent.html.twig',[
            'events'=>$events
        ]);
    }
    /**
     * @Route("/EventsAll", name="AfficheListeEvents")
     */
    public function AfficheListeEvents()
    {
        $session = new Session();
        $role=$session->get('role');
        $id=$session->get('id');
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $events=$rep->findAll();
        return $this->render('event/eventslist.html.twig',[
            'events'=>$events,'role'=>$role,'id'=>$id
        ]);
    }
    /**
     * @Route("/MesEvents/{id}", name="AfficheMaListeEvents")
     */
    public function AfficheEventsRec($id)
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $events=$rep->findByCreator($id);
        return $this->render('event/AfficheEventsRec.html.twig',[
            'events'=>$events
        ]);
    }
    /**
     * @Route("/EventsRegion/{title}", name="EventsParRégion")
     */
    public function AfficherEventsRegion($title)
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $events=$rep->findByVille($title);
        return $this->render('event/AfficheEventsRegion.html.twig',[
            'events'=>$events,
            'title'=>$title
        ]);
    }
    /**
     * @Route("/AfficheUnEventC/{id}", name="AfficherUnEventClient")
     */
    public function AfficheUnEventClient($id)
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $event=$rep->find($id);
        return $this->render('event/AfficheUnEClient.html.twig',[
            'event'=>$event
        ]);
    }

    /**
     * @param Event|null $event
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/AjoutEvent/{id}" , name="Ajout_Event")
     */
    public function AjoutEvent(Request $request, EntityManagerInterface $manager,Event $event = null, $id){
        if (!$event) {
            $event = new Event();
        }
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setCreatorID($id);
            $manager->persist($event);
            $manager->flush();
            $this->addFlash("message", "Evenement bien Ajouté");
            return $this->redirectToRoute('AfficherUnEventClient', ['id' => $event->getId()]);
        }
        return $this->render('event/AjoutEventClient.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route ("/Event/{id}/Modifier", name="ModifierEvent")
     */
    public function ModifierEvent(Event $event, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doc = $form->getData();
            $manager->persist($doc);
            $manager->flush();
            $this->addFlash("message", "Event bien Modifié");
            return $this->redirectToRoute('AfficherUnEventClient', ['id' => $doc->getId()]);
        }
        return $this->render('event/ModifierEvent.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route ("/Event/{id}/Supp", name="SupprimerEvent")
     */
    public function SupprimerEvent(Event $event): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('AfficheListeEvents');
    }


    /**
     * permet de participer ou annuler participation à un event
     * @Route ("/Article/{id}/Participate" , name="event_participe")
     * @param Event $event
     * @param EntityManagerInterface $manager
     * @param EventParticipationsRepository $repo
     * @return Response
     */
    public function Participe(Event $event, EntityManagerInterface $manager, MailerInterface $mailer,EventParticipationsRepository $repo): Response
    {

        $user = $this->getUser();
        if (!$user) return $this->json(['code' => 403, 'message' => "non connecté"], 403);
        if ($event->isParticipatedBy($user)) {
            $participation= $repo->findOneBy([
                'event' => $event,
                'user' => $user
            ]);
            $nom=$event->getNom();
            $email = (new Email())
                ->from('employini-b2c1b8@inbox.mailtrap.io')
                ->to($user->getEmail())
                ->subject('Inscription Event Annulé')
                ->text('Sending emails is fun again!')
                ->html('<p>Annulation à </p>'.$nom.'<p>réussie !</p>');
            $mailer->send($email);
            $manager->remove($participation);
            $manager->flush();
            return $this->json([
                'code' => 200,
                'message' => 'participation bien supprimé',
                'eventNom'=> $event->getNom(),
                'participations' => $repo->count(['event' => $event])
            ], 200);
        }
        $participation = new EventParticipations();
        $participation->setEvent($event)
            ->setUser($user);
        $nom=$event->getNom();
        $email = (new Email())
            ->from('employini-b2c1b8@inbox.mailtrap.io')
            ->to($user->getEmail())
            ->subject('Inscription Event')
            ->text('Sending emails is fun again!')
            ->html('<p>Inscription à </p>'.$nom.'<p>réussie !</p>');
        $mailer->send($email);

        $manager->persist($participation);
        $manager->flush();
        return $this->json(['code' => 200,
            'message' => 'participation bien ajouté',
            'eventNom'=>$event->getNom(),
            'participations' => $repo->count(['event' => $event])], 200);
    }

////////////////////////////////////////Partie Admin////////////////////////////
/// ////////////////////////////////////////////////////////////////////////////

    /**
     * @Route("/event/show", name="event_adminshow")
     */
    public function showEventsAdmin():Response
    {
        $events=$this->getDoctrine()->getRepository(Event::class)->findAll();

        return $this->render('event/index.html.twig',[
            'events'=>$events
        ]);
    }
    /**
     * @Route("/AfficheUnEventA/{id}", name="AfficherUnEventAdmin")
     */
    public function AfficheUnEventAdmin($id)
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $event=$rep->find($id);
        return $this->render('event/AfficheUnEA.html.twig',[
            'event'=>$event
        ]);
    }
}

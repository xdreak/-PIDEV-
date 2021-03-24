<?php

namespace App\Controller;

use App\Entity\Event;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{




//partie Client

    /**
     * @Route("/Events", name="showEventsFront")
     */
    public function showEventsFront()
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $events=$rep->findAll();
        return $this->render('event/events.html.twig',[
            'events'=>$events
        ]);
    }
    /**
     * @Route("/EventsAll", name="showEventsFrontList")
     */
    public function showEventsFrontAll()
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $events=$rep->findAll();
        return $this->render('event/eventslist.html.twig',[
            'events'=>$events
        ]);
    }
    /**
     * @Route("/event/showEFM/{title}", name="showEventFrontM")
     */
    public function showEventFrontMap($title)
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $events=$rep->findByVille($title);
        return $this->render('event/showEf.html.twig',[
            'events'=>$events,
            'title'=>$title
        ]);
    }
//Partie Admin
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
     * @Route("/event/showEF/{id}", name="showEventFront")
     */
    public function showEventFront($id)
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $events=$rep->find($id);
        return $this->render('event/showEf.html.twig',[
            'events'=>$events
        ]);
    }


    /**
     * @Route("/event/Participe/{id}", name="participeEvent")
     */
    public function participeEvent($id)
    {
        $rep=$this->getDoctrine()->getRepository(Event::class);
        $event=$rep->find($id);
        return $this->render('event/participe.html.twig',[
            'event'=>$event
        ]);
    }

}

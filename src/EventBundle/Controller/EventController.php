<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use EventBundle\Form\EventType;
use EventBundle\Entity\Event;

class EventController extends Controller
{
    public function createEventAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Envoyer',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setCreatedBy($this->getUser());
            $event->setCreatedAt(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute("core_homepage");
        }

        return $this->render("EventBundle:Form:create_event.html.twig", array('form' => $form->createView()));
    }

    public function allEventsAction()
    {
        $events = $this->getDoctrine()->getManager()->getRepository('EventBundle:Event')->findAll();

        $user = $this->getUser();
        return $this->render("UserBundle:User:all_events.html.twig", array('user' => $user, 'events' => $events));
    }

    public function registerUserForEventAction($id)
    {
        $event = $this->getDoctrine()->getManager()->getRepository('EventBundle:Event')->find($id);
        $placeAvailable = $event->getPlaceAvailable();

        if ($placeAvailable >= 1)
        {
            $event->addParticipant($this->getUser());
            $event->setPlaceAvailable($placeAvailable - 1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        }

        return $this->redirectToRoute("core_homepage");
    }

}

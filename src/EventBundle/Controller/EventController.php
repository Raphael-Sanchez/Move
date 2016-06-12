<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use EventBundle\Repository\EventRepository;
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
            $event->addParticipant($this->getUser());
            $event->setCreatedAt(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute("core_homepage");
        }

        return $this->render("EventBundle:Form:create_event.html.twig", array('form' => $form->createView()));
    }

    public function editEventAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EventBundle:Event')->find($id);
        if (!$event) {
            throw $this->createNotFoundException(
                'No news found for id ' . $id
            );
        }

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Envoyer',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return new Response('News updated successfully');
        }

//        $build['form'] = $form->createView();
//
//        return $this->render('FooNewsBundle:Default:news_add.html.twig', $build);
        return $this->render("EventBundle:Form:edit_event.html.twig", array('form' => $form->createView()));
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

        if($event->isUserParticipe($this->getUser()))
        {
            // return flashbag user deja enregistré
        }
        else
        {
            if($placeAvailable >= 1)
            {
                $event->addParticipant($this->getUser());
                $event->setPlaceAvailable($placeAvailable - 1);

                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();

            }
        }

        return $this->redirectToRoute("all_events");

    }

    public function unregisterUserForEventAction($id)
    {
        $event = $this->getDoctrine()->getManager()->getRepository('EventBundle:Event')->find($id);
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->find($this->getUser()->getId());
        $placeAvailable = $event->getPlaceAvailable();

        if($event->isUserParticipe($this->getUser()))
        {
            foreach($event->getParticipants() as $participant)
            {
                if($participant->getId() == $user->getId())
                {
                    $event->removeParticipant($participant);
                    $event->setPlaceAvailable($placeAvailable + 1);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($event);
                    $em->flush();

                    return $this->redirectToRoute("all_events");
                }
            }
        }
        else
        {
            // return flashbag user deja désenregistré
        }

    }

    public function allUserEventAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $eventsUser = $em->getRepository('EventBundle:Event')->findAllEventForOneUser($user);

        return $this->render("UserBundle:User:all_user_events.html.twig", array('user' => $user, 'events' => $eventsUser));
    }

}

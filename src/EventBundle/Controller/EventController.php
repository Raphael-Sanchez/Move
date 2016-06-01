<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EventBundle\Form\EventType;
use EventBundle\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            $event->setCreatedBy($this->getUser()->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute("core_homepage");
        }

        return $this->render("EventBundle:Form:create_event.html.twig", array('form' => $form->createView()));

    }
}

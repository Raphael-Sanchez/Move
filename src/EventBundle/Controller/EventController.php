<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\Event;
use EventBundle\Form\EventType;
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

//            return $this->render($this->generateUrl(
//                'create_event',
//                array('id' => $event->getId())
//            ));
        }

        return $this->render('EventBundle:Form:create.html.twig');
    }
}

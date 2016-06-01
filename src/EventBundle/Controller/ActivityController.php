<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EventBundle\Form\ActivityType;
use EventBundle\Entity\Activity;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ActivityController extends Controller
{
    public function createActivityAction(Request $request)
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Envoyer',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activity);
            $em->flush();

            return $this->redirectToRoute("core_homepage");
        }

        return $this->render("EventBundle:Form:create_activity.html.twig", array('form' => $form->createView()));

    }
}

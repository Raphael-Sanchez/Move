<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use UserBundle\Entity\UserEvent;


class UserController extends Controller
{
    public function createNewEventAction(Request $request, $id)
    {
        $user = $this->getUser();
        if($user != null)
        {
            if($user->getId() == $id)
            {
                $event = new UserEvent();

                $form = $this->createFormBuilder($event)
                    ->add('private', ChoiceType::class, array(
                        'label' => 'Type d\'évènement',
                        'required' => true,
                        'placeholder' => 'Veuillez sélectionner un type ...',
                        'choices' => array(
                            'Publique' => '0',
                            'Privé' => '1'
                        )))
                    ->add('placeAvailable', TextType::class, array(
                        'required' => true,
                    ))
                    ->add('validation', SubmitType::class, array('label' => 'Envoyer'))
                    ->getForm();

                $form->handleRequest($request);

                if ($form->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($form);
                    $em->flush();

                    return $this->redirect($this->generateUrl('/board'));
                }

                return $this->render('UserBundle:Form:new_event.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView()
                ));
            }
        }

        return $this->render('CoreBundle:Default:404.html.twig');
    }
}



<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function createNewEventAction($id)
    {
        $user = $this->getUser();
        if($user != null)
        {
            if($user->getId() == $id)
            {
                return $this->render('UserBundle:User:form_new_event.html.twig', array('user' => $user));
            }

            return $this->render('CoreBundle:Default:404.html.twig');
        }
    }
}

<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        if($user != null)
        {
            if($user->hasRole('ROLE_USER'))
            {
                return $this->render('UserBundle:User:board.html.twig', array('user' => $user));
            }
        }

        return $this->render('CoreBundle:Default:index.html.twig');
    }
}

<?php

namespace EventBundle\Repository;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

class EventRepository extends EntityRepository
{
    public function findAllEventForOneUser(User $user)
    {
        $query = $this->_em->createQuery('SELECT e FROM EventBundle:Event e JOIN e.participants p WHERE p = :user');
        $query->setParameter('user', $user);
        $result = $query->getResult();

        return $result;
    }
}
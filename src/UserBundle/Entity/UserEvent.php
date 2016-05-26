<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="user_event")
 */
class UserEvent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", name="private", nullable=false, options={"default": 0})
     */
    protected $private;

    /**
    * @var integer
    *
    * @Assert\NotBlank()
    * @ORM\Column(type="integer", nullable=false)
    */
    protected $placeAvailable;
}
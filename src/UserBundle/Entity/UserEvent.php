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
     * @Assert\NotNull()
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





    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UserEvent
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @param boolean $private
     * @return UserEvent
     */
    public function setPrivate($private)
    {
        $this->private = $private;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlaceAvailable()
    {
        return $this->placeAvailable;
    }

    /**
     * @param int $placeAvailable
     * @return UserEvent
     */
    public function setPlaceAvailable($placeAvailable)
    {
        $this->placeAvailable = $placeAvailable;
        return $this;
    }
}
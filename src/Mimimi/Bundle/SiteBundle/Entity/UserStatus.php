<?php

namespace Mimimi\Bundle\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class UserStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    
    /** 
     * @ORM\Column(name="title", type="string", length=255)
     */
    public $title;


    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="status")
     */
    public $users;


    public function getTitle()
    {
        return $this->title;
    }
}
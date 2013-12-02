<?php

namespace Mimimi\Bundle\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\Session;

use Mimimi\Bundle\SiteBundle\Entity\UserStatus;

/**
* @ORM\Entity
*/
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    
    /**
     * @ORM\Column(name="email", type="string", length=255)
     */
    public $email;

    
    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    public $password;

    
    /**
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    public $firstname;

    
    /**
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    public $lastname;


    /**
     * @ORM\Column(name="activated", type="boolean")
     */
    public $activated = false;


    /**
     * @ORM\ManyToOne(targetEntity="UserStatus")
     */
    public $status;


    /** 
     * @ORM\Column(name="date", type="datetime")
     */
    public $date;


    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="user")
     */
    public $items;



    private $name;



    public function login($controller) 
    {
        $data  = $controller->get('request')->request;
        $em = $controller->get('doctrine')->getManager();

        foreach((array)$this as $param => $v) {
            if (!is_null($data->get($param))) {
                $this->$param = $data->get($param);
            }
        }

        $this->password = md5($this->password);

        $entity = $em->getRepository("MimimiSiteBundle:User")->findOneBy(array('email' => $this->email, 'password' => $this->password));
        if ($entity) {
            $this->load($entity);
            $contoller->get('session')->set("_current_user", $this);
            return true;
        }
        return false;
    }


    public function create($controller) 
    {
        $data  = $controller->get('request')->request;
        $em = $controller->get('doctrine')->getManager();

        foreach((array)$this as $param => $v) {
            if (!is_null($data->get($param))) {
                $this->$param = $data->get($param);
            }
        }

        $this->date = new \DateTime("now");
        $this->password = md5($this->password);
        $this->status = $em->getRepository("MimimiSiteBundle:UserStatus")->find(1);
        list($this->firstname, $this->lastname) = explode(' ', $this->name);

        $em->persist($this);
        $em->flush();
    }


    public function load($data) 
    {
        foreach((array)$data as $key => $value) {
            if ($key && $value) 
            $this->$key = $value;
        }
    }
}
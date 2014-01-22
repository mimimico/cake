<?php

namespace Mimimi\Bundle\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\Session;

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
    public $activated = true;


    /**
     * @ORM\Column(name="status", type="integer", length=2)
     */
    public $status = 2; // MASTER


    /** 
     * @ORM\Column(name="date", type="datetime")
     */
    public $date;


    /** 
     * @ORM\Column(name="about", type="text")
     */
    public $about = "";


    /** 
     * @ORM\Column(name="country", type="string", length=255)
     */
    public $country = "";


    /** 
     * @ORM\Column(name="city", type="string", length=255)
     */
    public $city = "";


    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="user")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    public $items;



    public $name;


    public function getId()
    {
        return $this->id;
    }


    public function login($controller) 
    {
        $data = $controller->get('request')->request;
        $em = $controller->get('doctrine')->getManager();

        foreach((array)$this as $param => $v) {
            if (!is_null($data->get($param))) {
                $this->$param = $data->get($param);
            }
        }

        $this->password = md5($this->password);

        $entity = $em->getRepository("MimimiSiteBundle:User")->findOneBy(array('email' => $this->email, 'password' => $this->password, 'activated' => true));
        if ($entity) {
            $this->load($entity);
            $controller->get('session')->set("_current_user", $this);
            return true;
        }
        return false;
    }


    public function update($controller)
    {
        $data = $controller->get('request')->request;
        $em = $controller->get('doctrine')->getManager();

        $this->firstname = $data->get("firstname");
        $this->lastname = $data->get("lastname");
        $this->email = $data->get("email");
        $this->about = $data->get("about");
        $this->country = $data->get("country");
        $this->city = $data->get("city");

        if (md5($data->get("currentpass")) == $this->password) {
            if ($data->get("newpass") == $data->get("confirmpass")) {
                $this->password = md5($data->get("newpass"));
            }
        }

        $em->flush();
    }

    public function getCountry()
    {
        return $this->country == null ? "Unknown" : $this->country;
    }

    public function create($controller) 
    {
        $data = $controller->get('request')->request;
        $em = $controller->get('doctrine')->getManager();

        foreach((array)$this as $param => $v) {
            if (!is_null($data->get($param))) {
                $this->$param = $data->get($param);
            }
        }

        $this->date = new \DateTime("now");
        $this->password = md5($this->password);
        @list($this->firstname, $this->lastname) = explode(' ', $this->name);

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
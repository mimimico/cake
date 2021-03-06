<?php

namespace Mimimi\Bundle\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Mimimi\Bundle\SiteBundle\Entity\ItemImage;
use Mimimi\Bundle\SiteBundle\Entity\Country;
use Mimimi\Bundle\SiteBundle\Entity\Category;

/**
* @ORM\Entity
*/
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    
    /**
     * @ORM\OneToMany(targetEntity="ItemImage", mappedBy="item")
     */
    public $images;
    

    /** 
     * @ORM\ManyToOne(targetEntity="Category")
     */
    public $category;
    

    /** 
     * @ORM\ManyToOne(targetEntity="Country")
     */
    public $madein;
    

    /** 
     * @ORM\ManyToMany(targetEntity="Country")
     * @ORM\JoinTable(name="ItemShipping")
     */
    public $shipto;
    

    /** 
     * @ORM\ManyToOne(targetEntity="User")
     */
    public $user;


    /** 
     * @ORM\Column(name="title", type="string", length=255)
     */
    public $title;


    /** 
     * @ORM\Column(name="description", type="text")
     */
    public $description;


    /** 
     * @ORM\Column(name="price", type="float")
     */
    public $price;


    /** 
     * @ORM\Column(name="quantity", type="integer")
     */
    public $quantity = 0;


    /** 
     * @ORM\Column(name="sizes", type="string")
     */
    public $sizes = "";


    /** 
     * @ORM\Column(name="materials", type="string")
     */
    public $materials = "";


    /** 
     * @ORM\Column(name="tags", type="string")
     */
    public $tags = "";


    /** 
     * @ORM\Column(name="date", type="datetime")
     */
    public $date;



    public $_tmp_images = array();


    public function __construct($controller) 
    {
    	$data  = $controller->get('request')->request;
    	$files = $controller->get('request')->files;

    	$em = $controller->get('doctrine')->getManager();

    	foreach((array)$this as $param => $v) {
            if (!is_null($data->get($param))) {
                $this->$param = $data->get($param);
            }
		}

    	$this->date = new \DateTime("now");

    	$this->images = new ArrayCollection();
    	$this->shipto = new ArrayCollection();

        $this->user = $em->getRepository("MimimiSiteBundle:User")->find(
            $controller->get('session')->get('_current_user')->id
        );

    	if ($data->get("shipto") > 0) {
    		$this->shipto->add($em->getRepository("MimimiSiteBundle:Country")->find($data->get("shipto")));
		} else {
			$result = $em->getRepository("MimimiSiteBundle:Country")->findAll();
			foreach($result as $country) $this->shipto->add($country);
		}

    	$this->madein = $em->getRepository("MimimiSiteBundle:Country")->find(1);//TEMP First country in table (Ukraine)//$this->madein);
    	$this->category = $em->getRepository("MimimiSiteBundle:Category")->find($this->category);

    	foreach($files->get("images") as $image) {
    		if (!is_null($image)) {
    			$this->_tmp_images[] = new ItemImage($image);
    		}
    	}
    }


    public function update($controller)
    {
        $data  = $controller->get('request')->request;
        $files = $controller->get('request')->files;
        $em = $controller->get('doctrine')->getManager();

        $this->price = $data->get("price");
        $this->title = $data->get("title");
        $this->sizes = $data->get("sizes");
        $this->description = $data->get("description");
        $this->materials = $data->get("materials");

        $this->category = $em->getRepository("MimimiSiteBundle:Category")->find($data->get("category"));

        foreach($files->get("images") as $image) {
            if (!is_null($image)) {
                $this->_tmp_images[] = new ItemImage($image);
            }
        }

        foreach($this->_tmp_images as $image) {
            $image->item = $this;
            $em->persist($image);
            $this->addItemImage($image);
        }

        $em->flush();
    }

    public function getCategory() 
    {
        return $this->category;
    }

    public function addItemImage(ItemImage $image) 
    {
    	$this->images->add($image);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTags()
    {
        $list = explode(",", $this->tags);
        array_walk($list, "trim");
        return $list;
    }

    public function getMaterials()
    {
        $list = explode(",", $this->materials);
        array_walk($list, "trim");
        return $list;
    }

    public function isValid()
    {
    	return true;
    }

    public function push($em) 
    {
    	$em->persist($this);

    	foreach($this->_tmp_images as $image) {
    		$image->item = $this;
    		$em->persist($image);
    		$this->addItemImage($image);
    	}

    	$em->flush();
    }
}
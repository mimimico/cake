<?php

namespace Mimimi\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mimimi\Bundle\SiteBundle\Entity\Item;

class DefaultController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="_index")
     */
    public function indexAction()
    {
    	return $this->redirect($this->generateUrl("_item_add"));
    }


    /**
     * @Template("MimimiSiteBundle:Default:item-add.html.twig")
     * @Route("/item/add", name="_item_add")
     */
    public function itemAddAction()
    {
        $em = $this->get('doctrine')->getManager();

        if ($this->get('request')->getMethod() == "POST") {
        	/* Create new item */
	        $item = new Item($this);

	        if ($item->isValid()) {
	        	/* Pushing it to database */
	        	$item->push($em);

	        	return $this->redirect($this->generateUrl('_index'));
	        } else {
	        	/* Woops, we have an error */
	        	return array();
	        }
        } else {
        	return array(
	    		"categories" => $em->getRepository("MimimiSiteBundle:Category")->findAll(),
	    		"countries"  => $em->getRepository("MimimiSiteBundle:Country") ->findAll()
			);
        }
    }
}

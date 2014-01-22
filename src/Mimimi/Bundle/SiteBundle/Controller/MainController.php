<?php

namespace Mimimi\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mimimi\Bundle\SiteBundle\Entity\User;
use Mimimi\Bundle\SiteBundle\Interfaces\UserRestricted;

class MainController extends Controller implements UserRestricted
{
    /**
     * @Route("/", name="_index")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine')->getManager();
        $items = $em->getRepository("MimimiSiteBundle:Item")->findBy(array(), array("id" => "DESC"));

    	return array(
            "categories" => $em->getRepository("MimimiSiteBundle:Category")->findAll(),
    		"items" => $items
		);
    }    

    /**
     * @Template("MimimiSiteBundle:Main:index.html.twig")
     * @Route("/category/{id}", name="_item_category", requirements={"id" = "\d+"})
     */
    public function caregoryAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $items = $em->getRepository("MimimiSiteBundle:Category")->find($id)->getItems();
        
        return array(
            "categories" => $em->getRepository("MimimiSiteBundle:Category")->findAll(),
            "items" => $items
        );
    }
}

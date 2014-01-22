<?php

namespace Mimimi\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mimimi\Bundle\SiteBundle\Entity\User;

class SplashController extends Controller
{
    
    /**
     * @Template("MimimiSiteBundle:Splash:splash_login.html.twig")
     * @Route("/login", name="_splash_login")
     */
    public function splashLoginAction()
    {
        $em = $this->get('doctrine')->getManager();

        if ($this->get('request')->getMethod() == "POST") {
	        $user = new User();

	        if ($user->login($this)) {
	        	return $this->redirect($this->generateUrl('_index'));
	        } else {
	        	/* Woops, we have an error */
	        	return array();
	        }
        } else {
    		return array();
    	}
    }


    /**
     * @Template("MimimiSiteBundle:Splash:splash_registration.html.twig")
     * @Route("/registration", name="_splash_register")
     */
    public function splashRegisterAction()
    {
        $em = $this->get('doctrine')->getManager();

        if ($this->get('request')->getMethod() == "POST") {
	        $user = new User();

	        if ($user->create($this)) {
	        	return $this->redirect($this->generateUrl('_splash_message'));
	        } else {
	        	/* Woops, we have an error */
	        	return array();
	        }
        } else {
    		return array();
    	}
    }


    /**
     * @Template("MimimiSiteBundle:Splash:splash_message.html.twig")
     * @Route("/welcome", name="_splash_message")
     */
    public function splashMessageAction()
    {
    	return array();
    }
}

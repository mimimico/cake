<?php

namespace Mimimi\Bundle\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mimimi\Bundle\SiteBundle\Interfaces\UserRestricted;

/**
 * @Route("/user")
 */
class UserController extends Controller implements UserRestricted
{
    /**
     * @Template("MimimiSiteBundle:User:profile.html.twig")
     * @Route("/", name="_user_index")
     * @Route("/{id}", requirements={"id" = "\d+"})
     */
    public function indexAction($id = 0)
    {
        if (!$id) {
            $id = $this->getRequest()->getSession()->get('_current_user')->id;
        }

        $em = $this->get('doctrine')->getManager();
        $user = $em->getRepository("MimimiSiteBundle:User")->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        return array(
            "user"  => $user
    	);
    }


    /**
     * @Template("MimimiSiteBundle:User:edit.html.twig")
     * @Route("/edit", name="_user_edit")
     */
    public function editAction()
    {
        $em = $this->get('doctrine')->getManager();

        $id = $this->getRequest()->getSession()->get('_current_user')->id;
        $user = $em->getRepository("MimimiSiteBundle:User")->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        if ($this->get('request')->getMethod() == "POST") {
            /* Update user data */
            $user->update($this);
        }

        return array(
            "user"  => $user
        );
    }


    /**
     * @Route("/logout", name="_user_logout")
     */
    public function logoutAction()
    {
        $this->getRequest()->getSession()->set('_current_user', null);
        return $this->redirect($this->generateUrl("_index"));
    }
}

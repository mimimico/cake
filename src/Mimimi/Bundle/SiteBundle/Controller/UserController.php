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
     * @Template("MimimiSiteBundle:Default:profile-master.html.twig")
     * @Route("/")
     * @Route("/{id}", requirements={"id" = "\d+"})
     */
    public function indexAction($id = 0)
    {
        if (!$id) {
            $id = $this->get('session')->get('_current_user')->id;
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
}

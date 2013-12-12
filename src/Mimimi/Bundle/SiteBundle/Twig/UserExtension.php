<?php

namespace Mimimi\Bundle\SiteBundle\Twig;

class UserExtension extends \Twig_Extension
{
    private $_session;

    public function __construct($session)
    {
        $this->_session = $session;
    }

    public function getName()
    {
        return 'user_extension';
    }

    public function getGlobals()
    {
        return array(
            "_current_user" => $this->_session->get("_current_user"),
        );
    }
}
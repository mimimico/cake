<?php

namespace Mimimi\Bundle\SiteBundle\EventListener;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

use Mimimi\Bundle\SiteBundle\Interfaces\UserRestricted;

class UserListener
{
    private $router;
    private $session;

    public function __construct($router, $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure. This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof UserRestricted) {
            if (!$this->session->get("_current_user")) {
                $redirectUrl = $this->router->generate("_splash_register");
                $event->setController(function() use ($redirectUrl) {
                    return new RedirectResponse($redirectUrl);
                });
            }
        }
    }
}
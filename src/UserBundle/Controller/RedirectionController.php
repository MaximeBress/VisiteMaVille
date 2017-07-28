<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RedirectionController extends Controller
{
    /**
     * @Route("/safe-login", name="user_login_redirect")
     */
    public function redirectAction()
    {
        if (false !== $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || false !== $this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('application_homepage'));
        }
        if (false !== $this->get('security.authorization_checker')->isGranted('ROLE_SELLER')) {
            return $this->redirect($this->generateUrl('application_homepage'));
        }
        if (false !== $this->get('security.authorization_checker')->isGranted('ROLE_CUSTOMER')) {
            return $this->redirect($this->generateUrl('front_homepage'));
        }
        if (false !== $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('application_homepage'));
        }
        return $this->redirect($this->generateUrl('front_homepage'));
    }
}

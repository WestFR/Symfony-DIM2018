<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route(name="security_")
 */
class AuthController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authUtils) {

        return $this->render('auth/login.html.twig', [
            'error' => $authUtils->getLastAuthenticationError(),
            'lastUsername' => $authUtils->getLastUsername()
        ]);
    }

    // ROUTES INTERCEPT BY FIREWALL
        /**
         * @Route("/login_check", name="login_check")
         */
        public function loginCheckAction() {
            dump("This code is never executed");
        }

        /**
         * @Route("/logout", name="logout")
         */
        public function logoutCheckout() {
        }
    // ROUTES INTERCEPT BY FIREWALL
}
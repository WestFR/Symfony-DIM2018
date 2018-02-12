<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\User;
use AppBundle\Type\UserType;

/**
 * @Route("/user", name="user_")
 */
class UserController extends Controller {


	/**
	 * @Route("/create", name="create")
	 */
	public function createAction(Request $request) {

		$user = new User();
        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'You successfully added a new user !');
            return $this->redirectToRoute('show_list');
        }
        
        return $this->render('user/create.html.twig', ['userForm' => $userForm->createView()]);
	}

}
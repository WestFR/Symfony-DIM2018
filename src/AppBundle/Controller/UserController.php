<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

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
	public function createAction(Request $request, EncoderFactoryInterface $encoderFactory) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'NOT PASS');

		$user = new User();
        $userForm = $this->createForm(UserType::class, $user, ['validation_groups' => 'user_create']);

        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $encoder = $encoderFactory->getEncoder($user);
            $hashedPassword = $encoder->encodePassword($user->getPassword(),null);

            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'You successfully added a new user !');
            return $this->redirectToRoute('user_list');
        }
        
        return $this->render('user/create.html.twig', ['userForm' => $userForm->createView()]);
	}

    /**
     * @Route("/list", name="list")
     */
    public function listAction()
    {
        return $this->render('user/list.html.twig',[
            'users' => $this->getDoctrine()->getRepository(User::class)->findAll()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateAction(Request $request, User $user, EncoderFactoryInterface $encoderFactory) {

        $userForm = $this->createForm(UserType::class, $user, ['validation_groups' => 'user_update']);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $encoder = $encoderFactory->getEncoder($user);
            $hashedPassword = $encoder->encodePassword($user->getPassword(),null);

            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'You successfully updated the user !');
            return $this->redirectToRoute('user_list');
        }
        return $this->render('user/create.html.twig', ['userForm' => $userForm->createView()]);
    }

    /**
     * @Route("/delete", name="delete")
     * @Method({"POST"})
     */
    public function deleteAction(Request $request, CsrfTokenManagerInterface $csrfTokenManager) {

        $doctrine = $this->getDoctrine();
        $showID = $request->request->get('user_id');
        

        if(!$show = $doctrine->getRepository(User::class)->findOneById($showID)) {
            throw  new NotFoundException(sprintf('There is no user with the id %d', $showID));
        }

        $csrfToken = new CsrfToken('delete_user', $request->request->get('_csrf_token'));

        if($csrfTokenManager->isTokenValid($csrfToken)) {
            $doctrine->getManager()->remove($show);
            $doctrine->getManager()->flush();

            $this->addFlash('success', 'The user have been successfully deleted.');
        } else {
            $this->addFlash('danger', 'Then csrf token is not valid. The deletion was not completed.');
        }
        return $this->redirectToRoute('user_list'); 
    }
}
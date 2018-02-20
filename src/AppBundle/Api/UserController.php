<?php

namespace AppBundle\Api;

use AppBundle\Entity\User;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**	
 * @Route("/users", name="api_users")
 */
class UserController extends Controller {

	/**
	 * @Method({"GET"})
	 * @Route("/all", name="_list")
	 */
	public function getAll(SerializerInterface $serializer) {
		$users = $this->getDoctrine()->getRepository(User::class)->findAll();

		$serialzationContext = SerializationContext::create();
		
		return $this->returnResponse(
			$serializer->serialize($users, 'json', $serialzationContext->setGroups(['user'])),
			Response::HTTP_OK
		);
	}

	/**
	 * @Method({"GET"})
	 * @Route("/{id}", name="_get")
	 */
	public function getOne(User $user, SerializerInterface $serializer) {
		
		$serialzationContext = SerializationContext::create();
		
		return $this->returnResponse(
			$serializer->serialize($user, 'json', $serialzationContext->setGroups(['user'])),
			Response::HTTP_OK
		);
	}
}
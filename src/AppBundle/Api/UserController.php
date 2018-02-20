<?php

namespace AppBundle\Api;

use AppBundle\Entity\User;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

		$serializationContext = SerializationContext::create();
		
		return $this->returnResponse(
			$serializer->serialize($users, 'json', $serializationContext->setGroups(['user'])),
			Response::HTTP_OK
		);
	}

	/**
	 * @Method({"GET"})
	 * @Route("/{id}", name="_get")
	 */
	public function getOne(User $user, SerializerInterface $serializer) {
		
		$serializationContext = SerializationContext::create();
		
		return $this->returnResponse(
			$serializer->serialize($user, 'json', $serializationContext->setGroups(['user'])),
			Response::HTTP_OK
		);
	}

	/**
	 * @Method({"POST"})
	 * @Route("/create", name="_create")
	 */
	public function createAction(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EncoderFactoryInterface $encoderFactory) {

		$serializationContext = DeserializationContext::create();

		$user = $serializer->deserialize($request->getContent(), User::class, 'json', $serializationContext->setGroups(['user_create', 'user']));
		$constraintValidator = $validator->validate($user);

		if($constraintValidator->count() == 0) {

            $encoder = $encoderFactory->getEncoder($user);
            $hashedPassword = $encoder->encodePassword($user->getPassword() , null);
            $user->setPassword($hashedPassword);

			$user->setRoles(explode(', ', $user->getRoles()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

			return $this->returnResponse('User Created', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @Method({"PUT"})
	 * @Route("/update/{id}", name="_update")
	 */
	public function updateAction(User $user, Request $request, SerializerInterface $serializer, 
		ValidatorInterface $validator, EncoderFactoryInterface $encoderFactory) {

		$newUser = $serializer->deserialize($request->getContent(), User::class, 'json');
		$constraintValidator = $validator->validate($newUser);

		if($constraintValidator->count() == 0) {
			
			//$user->update($newUser);
			//$encoder = $encoderFactory->getEncoder($user);
            //$hashedPassword = $encoder->encodePassword($user->getPassword(),null);
            //$user->setPassword($hashedPassword);

			$this->getDoctrine()->getManager()->flush();

			return $this->returnResponse('User updated', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @Method({"DELETE"})
	 * @Route("/delete/{id}", name="_delete")
	 */
	public function deleteAction(User $user, Request $request, ValidatorInterface $validator) {

		$constraintValidator = $validator->validate($user);

		if($constraintValidator->count() == 0) {
			$this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();

			return $this->returnResponse('User removed', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}



}
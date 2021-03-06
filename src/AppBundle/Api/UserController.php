<?php

namespace AppBundle\Api;

use AppBundle\Entity\User;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializerInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

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
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="Return alls users.",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=User::class)
     *     )
     * )
     *
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
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="Return one specified user.",
     *     @Model(type=User::class)
     * )
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
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="User created"
     * )
     *
     * @SWG\Parameter(
     *     name="user",
     *     in="body",
     *     type="array",
     *	   @SWG\Schema(ref="#/definitions/User"),
     *     description="User informations (see Model below for more informations)."
     * )
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
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="User updated"
     * )
	 */
	public function updateAction(User $user, Request $request, SerializerInterface $serializer, 
		ValidatorInterface $validator, EncoderFactoryInterface $encoderFactory) {

		$serializationContext = DeserializationContext::create();

		$newUser = $serializer->deserialize($request->getContent(), User::class, 'json', $serializationContext->setGroups(['user_update']));

		$constraintValidator = $validator->validate($newUser);

		if($constraintValidator->count() == 0) {

			if($newUser->getPassword() != null) {
				$encoder = $encoderFactory->getEncoder($newUser);
            	$hashedPassword = $encoder->encodePassword($newUser->getPassword(),null);
            	$newUser->setPassword($hashedPassword);
			}
					
			$user->update($newUser);
			$this->getDoctrine()->getManager()->flush();

			return $this->returnResponse('User updated', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @Method({"DELETE"})
	 * @Route("/delete/{id}", name="_delete")
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="User removed"
     * )
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
<?php

namespace AppBundle\Api;

use AppBundle\Entity\Category;
use AppBundle\Entity\Show;
use AppBundle\Entity\User;

use JMS\Serializer\SerializerInterface;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Validator\ValidatorInterface;

/**	
 * @Route("/shows", name="api_shows")
 */
class ShowController extends Controller {

	/**
	 * @Method({"GET"})
	 * @Route("/all", name="_list")
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="Return alls shows.",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=Show::class)
     *     )
     * )
     */
	public function getAll(SerializerInterface $serializer) {
		$shows = $this->getDoctrine()->getRepository(Show::class)->findAll();
		return $this->returnResponse($serializer->serialize($shows, 'json'), Response::HTTP_OK);
	}

	/**
	 * @Method({"GET"})
	 * @Route("/{id}", name="_get")
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="Return one specified show.",
     *     @Model(type=Show::class)
     * )
	 */
	public function getOne(Show $show, SerializerInterface $serializer) {
		return $this->returnResponse($serializer->serialize($show, 'json'), Response::HTTP_OK);
	}

	/**
	 * @Method({"POST"})
	 * @Route("/create", name="_create")
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="Show created"
     * )
     *
     * @SWG\Parameter(
     *     name="show",
     *     in="body",
     *     type="array",
     *	   @SWG\Schema(ref="#/definitions/Show"),
     *     description="Show information (see Models below for more informations)."
     * )
	 */
	public function createAction(Request $request, SerializerInterface $serializer, ValidatorInterface $validator) {
		
		$show = $serializer->deserialize($request->getContent(), Show::class, 'json');

		$constraintValidator = $validator->validate($show);

		if($constraintValidator->count() == 0) {

			$em = $this->getDoctrine()->getManager();

			$userRepo = $em->getRepository(User::class);
			$catRepo = $em->getRepository(Category::class);
  	
  			if($userRepo->findOneByFullname($show->getAuthor()->getFullname()) != null) {
  				$show->setAuthor($userRepo->findOneByFullname($show->getAuthor()->getFullname()));
  			}
  			else {
  				return $this->returnResponse("User doesn't exists, create that before.", Response::HTTP_CREATED);
  			}

  			if($catRepo->findOneByName($show->getCategory()->getName()) != null) {
  				$show->setCategory($catRepo->findOneByName($show->getCategory()->getName()));
  			}
  			else {
  				return $this->returnResponse("Category doesn't exists, create that before.", Response::HTTP_CREATED);
  			}
			
            $show->setDataSource(Show::DATA_SOURCE_DB_API);
            
			$em->persist($show);
			$em->flush();

			return $this->returnResponse('Show created', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @Method({"PUT"})
	 * @Route("/update/{id}", name="_update")
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="Show updated"
     * )
	 */
	public function updateAction(Show $show, Request $request, SerializerInterface $serializer, ValidatorInterface $validator) {

		//$serializationContext = DeserializationContext::create();
		//$newUser = $serializer->deserialize($request->getContent(), User::class, 'json', $serializationContext->setGroups(['user_update']));
		$newShow = $serializer->deserialize($request->getContent(), Show::class, 'json');

		$constraintValidator = $validator->validate($newShow);

		if($constraintValidator->count() == 0) {

			$em = $this->getDoctrine()->getManager();

			if($newShow->getAuthor() != null) {
				$userRepo = $em->getRepository(User::class);
				$newShow->setAuthor($userRepo->findOneByFullname($show->getAuthor()->getFullname()));
			} 

			if($newShow->getCategory() != null) {
				$catRepo = $em->getRepository(Category::class);
				$newShow->setCategory($catRepo->findOneByName($show->getCategory()->getName()));
			}
			
			$show->update($newShow);
			$this->getDoctrine()->getManager()->flush();

			return $this->returnResponse('Show updated', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @Method({"DELETE"})
	 * @Route("/delete/{id}", name="_delete")
	 *
	 * @SWG\Response(
     *     response=200,
     *     description="Show removed"
     * )
	 */
	public function deleteAction(Show $show, Request $request, ValidatorInterface $validator) {

		$constraintValidator = $validator->validate($show);

		if($constraintValidator->count() == 0) {
			$this->getDoctrine()->getManager()->remove($show);
            $this->getDoctrine()->getManager()->flush();

			return $this->returnResponse('Show removed', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}
}
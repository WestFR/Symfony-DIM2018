<?php

namespace AppBundle\Api;

use AppBundle\Entity\Category;

use JMS\Serializer\SerializerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Validator\ValidatorInterface;

/**	
 * @Route("/categories", name="api_categories")
 */
class CategoryController extends Controller {

	/**
	 * @Method({"GET"})
	 * @Route("/all", name="_list")
	 */
	public function getAll(SerializerInterface $serializer) {
		$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
		return $this->returnResponse($serializer->serialize($categories, 'json'), Response::HTTP_OK);
	}

	/**
	 * @Method({"GET"})
	 * @Route("/{id}", name="_get")
	 */
	public function getOne(Category $category, SerializerInterface $serializer) {
		return $this->returnResponse($serializer->serialize($category, 'json'), Response::HTTP_OK);
	}

	/**
	 * @Method({"POST"})
	 * @Route("/create", name="_create")
	 */
	public function createAction(Request $request, SerializerInterface $serializer, ValidatorInterface $validator) {

		$category = $serializer->deserialize($request->getContent(), Category::class, 'json');

		$constraintValidator = $validator->validate($category);

		if($constraintValidator->count() == 0) {
			$em = $this->getDoctrine()->getManager();

			$em->persist($category);
			$em->flush();

			return $this->returnResponse('Category created', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @Method({"PUT"})
	 * @Route("/update/{id}", name="_update")
	 */
	public function updateAction(Category $category, Request $request, SerializerInterface $serializer, ValidatorInterface $validator) {

		$newCategory = $serializer->deserialize($request->getContent(), Category::class, 'json');
		$constraintValidator = $validator->validate($newCategory);

		if($constraintValidator->count() == 0) {
			
			$category->update($newCategory);
			$this->getDoctrine()->getManager()->flush();
			
			return $this->returnResponse('Category updated', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @Method({"DELETE"})
	 * @Route("/delete/{id}", name="_delete")
	 */
	public function deleteAction(Category $category, Request $request, ValidatorInterface $validator) {

		$constraintValidator = $validator->validate($category);

		if($constraintValidator->count() == 0) {
			$this->getDoctrine()->getManager()->remove($category);
            $this->getDoctrine()->getManager()->flush();

			return $this->returnResponse('Category removed', Response::HTTP_CREATED);
		}

		return $this->returnResponse($serializer->serialize($constraintValidator, 'json'), Response::HTTP_BAD_REQUEST);
	}
}
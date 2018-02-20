<?php

namespace AppBundle\Api;

use AppBundle\Entity\Category;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

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
}
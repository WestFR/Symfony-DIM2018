<?php

namespace AppBundle\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Serializer\SerializerInterface;

use AppBundle\Entity\Category;

/**	
 * @Route("/categories", name="api_categories_list")
 */
class CategoryController extends Controller {

	/**
	 * @Method({"GET"})
	 * @Route("/all", name="api_categories_list")
	 */
	public function getAll(SerializerInterface $serializer) {

		$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
		$data = $serializer->serialize($categories, 'json');

		return new Response($data);
	}

	/*public function get() {

	}*/
}
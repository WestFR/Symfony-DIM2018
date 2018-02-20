<?php

namespace AppBundle\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Show;

class ShowController extends Controller {

	/**
	 * @Method({"GET"})
	 * @Route("/shows", name="api_shows_list")
	 */
	public function getAll() {

		$shows = $this->getDoctrine()->getRepository(Show::class)->findAll();
		return new JsonResponse($shows);
	}

	/*public function get() {

	}*/
}
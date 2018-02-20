<?php

namespace AppBundle\Api;

use AppBundle\Entity\Show;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**	
 * @Route("/shows", name="api_shows")
 */
class ShowController extends Controller {

	/**
	 * @Method({"GET"})
	 * @Route("/all", name="_list")
	 */
	public function getAll(SerializerInterface $serializer) {
		$shows = $this->getDoctrine()->getRepository(Show::class)->findAll();
		return $this->returnResponse($serializer->serialize($shows, 'json'), Response::HTTP_OK);
	}

	/**
	 * @Method({"GET"})
	 * @Route("/{id}", name="_get")
	 */
	public function getOne(Show $show, SerializerInterface $serializer) {
		return $this->returnResponse($serializer->serialize($show, 'json'), Response::HTTP_OK);
	}
}
<?php

namespace AppBundle\Api;

use AppBundle\Entity\Media;
use AppBundle\Type\MediaType;
use AppBundle\File\FileUploader;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\RoutingGeneratorInterface;

use Symfony\Component\Validator\Validator\ValidatorInterface;

/**	
 * @Route("/media", name="api_medias")
 */
class MediaController extends Controller {

	/**
	 * @Method({"POST"})
	 * @Route("/", name="_upload")
	 */
	public function uploadAction(Request $request, FileUploader $fileUploader, RouterInterface $router) {

		$media = new Media();
		$media->setFile($request->files->get('file')); 

		// Validate media object

		$generatedFileName = $fileUploader->upload($media->getFile(), time());
		
		$path = $this->container->getParameter('upload_directory_file').'/'.$generatedFileName;

		$baseUrl = $router->getContext()->getScheme().'://'.$router->getContext()->getHost().':'.$router->getContext()->getHttpPort();
        $media->setPath($baseUrl.$path);

        $em = $this->getDoctrine()->getManager();
        $em->persist($media);
		$em->flush();

        return $this->returnResponse('Media uploaded, path is : '.$media->getPath(), Response::HTTP_CREATED);

		//return $this->returnResponse('Media not uploaded', Response::HTTP_BAD_REQUEST);

	}
	
}
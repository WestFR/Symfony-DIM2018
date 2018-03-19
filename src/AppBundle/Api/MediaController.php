<?php

namespace AppBundle\Api;

use AppBundle\Entity\Media;
use AppBundle\Type\MediaType;
use AppBundle\File\FileUploader;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Validator\ValidatorInterface;

/**	
 * @Route("/media", name="api_medias")
 */
class MediaController extends Controller {

	/**
	 * @Method({"POST"})
	 * @Route("/", name="_upload")
	 */
	public function uploadAction(Request $request) {

		$media = new Media();
		$form = $this->createForm(MediaType::class, $media);

		$form->handleRequest($request);

		if($form->isValid()) {

			$generatedFileName = $fileUploader->upload($media->getFile(), time());
			$path = $this->container->getParameter('upload_directory_file').$generatedFileName;

            $media->setPath($request->getBaseUrl().$path);

        	return $this->returnResponse('Media uploaded', Response::HTTP_CREATED);
		}

		return $this->returnResponse('Media not uploaded', Response::HTTP_BAD_REQUEST);

	}
	
}
<?php

namespace AppBundle\Serializer\Listener;

use AppBundle\Entity\Show;

use Doctrine\Common\Persistence\ManagerRegistry;

use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShowListener implements EventSubscriberInterface {

	private $doctrine;
	private $tokenStorage;

	public function __construct(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage) {
		$this->docrine = $doctrine;
		$this->tokenStorage = $tokenStorage;
	}

	public static function getSubscribedEvents() {
		
		return [
			[
				'event' => Events::POST_DESERIALIZE,
				'method' => 'postDeserialize',
				'class' => 'AppBundle\\Entity\\Show',
				'format' => 'json',
			],
		];
	}

	public function postDeserialize(PostDeserializeEvent $event) {

		$data = $event->getData();

		$show = new Show();

		$show 
			->setName($data['name'])
			->setAbstract($data['abstract'])
			->setCountry($data['country'])
			->setReleaseDate(new \DateTime($data['release_date']))
			->setMainPicture($data['main_picture'])
		;

		$em = $this->doctrine->getManager();

		if(! $category = $em->getRepository('AppBundle:Category')->findOneBy($data['catgoery']['id'])) {
			throw new Exception("The category doesn't exists");
		}

		$show->setCategory($category);

		$user = $this->tokenStorage->getToken()->getUser();
		$show->setAuthor($user);

		dump($show);die;
		return $show;

	}
}
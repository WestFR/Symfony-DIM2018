<?php

namespace AppBundle\Serializer\Listener;

use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubcriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;

class ShowListener implements EventSubcriberInterface {

	public static function getSubcribedEvents() {
		
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
		dump($event->getObject());die;
	}
}
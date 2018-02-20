<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 *
 * @UniqueEntity("name", message="{{ value }} is already in database.")
 *
 * @JMS\ExclusionPolicy("all")
 */
class Category {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", unique=true)
	 *
	 * @JMS\Expose
	 */
	private $name;

	public function getid() {
		return $this->id;
	}

	public function getName () {
		return $this->name;
	}

	public function setName ($name) {
		$this->name = $name;
	}

}
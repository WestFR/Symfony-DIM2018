<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 * @UniqueEntity("name", message="{{ value }} is already in database.")
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
	 */
	private $name;

	public function getName () {
		return $this->name;
	}

	public function setName ($name) {
		$this->name = $name;
	}

}
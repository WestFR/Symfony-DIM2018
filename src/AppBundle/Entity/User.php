<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @UniqueEntity("name", message="{{ value }} is already in database.")
 */
class User {

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

	/**
	 * @ORM\Column(type="string")
	 */
	private $surname;


	public function getid() {
		return $this->id;
	}

	public function getName () {
		return $this->name;
	}

	public function setName ($name) {
		$this->name = $name;
	}

	public function getSurname () {
		return $this->name;
	}

	public function setSurname ($surname) {
		$this->surname = $surname;
	}

}
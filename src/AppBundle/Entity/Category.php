<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Swagger\Annotations as SWG;

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
	 * @Assert\NotBlank
	 *
	 * @JMS\Expose
	 * @SWG\Property(description="Unique name of the category.")
	 */
	private $name;

	public function getid() {
		return $this->id;
	}

	public function setid($id) {
		$this->id = $id;
	}

	public function getName () {
		return $this->name;
	}

	public function setName ($name) {
		$this->name = $name;
	}

	// Update Method
	public function update(Category $category) {
		$this->name = $category->getName();
	}

}
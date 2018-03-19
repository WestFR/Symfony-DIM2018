<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Swagger\Annotations as SWG;

/**
 * @ORM\Entity
 * @ORM\Table(name="medias")
 *
 * @UniqueEntity("name", message="{{ value }} is already in database.")
 *
 * @JMS\ExclusionPolicy("all")
 */
class Media {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	private $file;

	/**
	 * @ORM\Column(type="string", unique=true)
	 *
	 * @JMS\Expose
	 * @SWG\Property(description="Unique path of the media.")
	 */
	private $path;

	public function getid() {
		return $this->id;
	}

	public function setid($id) {
		$this->id = $id;
	}

	public function getFile () {
		return $this->file;
	}

	public function setFile ($file) {
		$this->file = $file;
	}

	public function getPath () {
		return $this->path;
	}

	public function setPath ($path) {
		$this->path = $path;
	}

}
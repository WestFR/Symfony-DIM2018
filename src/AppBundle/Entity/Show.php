<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_shows")
 */
class Show {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column
	 * @Assert\NotBlank(message="Please provide a name for the show.")
	 */
	private $name;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank
	 */
	private $abstract;

	/**
	 * @ORM\Column
	 * @Assert\NotBlank
	 */
	private $country;

	/**
	 * @ORM\Column
	 * @Assert\NotBlank
	 */
	private $author;

	/**
	 * @ORM\Column(type="date")
	 * @Assert\NotBlank
	 */
	private $releaseDate;

	/**
	 * @ORM\Column
	 * @Assert\Image(minHeight=300, minWidth=750)
	 */
	private $mainPicture;

	/**
	 * @ORM\ManyToOne(targetEntity="Category")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
	 *
	 * @Assert\NotBlank
	 */
	private $category;


	// Getter / Setters //
	public function getName () {
		return $this->name;
	}

	public function setName ($name) {
		$this->name = $name;
	}

	public function getAbstract () {
		return $this->abstract;
	}
	
	public function setAbstract ($abstract){
		$this->abstract = $abstract;
	}

	public function getCountry () {
		return $this->country;
	}
	
	public function setCountry ($country) {
		$this->country = $country;
	}

	public function getAuthor () {
		return $this->author;
	}
	
	public function setAuthor ($author) {
		$this->author = $author;
	}

	public function getReleaseDate () {
		return $this->releaseDate;
	}
	
	public function setReleaseDate ($releaseDate) {
		$this->releaseDate = $releaseDate;
	}

	public function getMainPicture () {
		return $this->mainPicture;
	}
	
	public function setMainPicture ($mainPicture) {
		$this->mainPicture = $mainPicture;
	}

	public function getCategory () {
		return $this->category;
	}
	
	public function setCategory ($category) {
		$this->category = $category;
	}
	// Getter / Setters //

}
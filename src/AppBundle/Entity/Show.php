<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use AppBundle\Entity\User;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ShowRepository")
 * @ORM\Table(name="s_shows")
 */
class Show {

	// Data source const
	const DATA_SOURCE_OMDB = 'OMDB';
	const DATA_SOURCE_DB = 'LOCAL_DATABASE';

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column
	 * @Assert\NotBlank(message="Please provide a name for the show.", groups={"create", "update"})
	 */
	private $name;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank(groups={"create", "update"})
	 */
	private $abstract;

	/**
	 * @ORM\Column
	 * @Assert\NotBlank(groups={"create", "update"})
	 */
	private $country;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank(groups={"create", "update"})
	 */
	private $realisator;

	/**
      * @ORM\Column(type="string")
      * @Assert\NotBlank(groups={"create","update"})
      * @ORM\ManyToOne(targetEntity="User", inversedBy="shows")
      * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
      */
	private $author;

	/**
	 * @ORM\ManyToOne(targetEntity="Category")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
	 *
	 * @Assert\NotBlank(groups={"create", "update"})
	 */
	private $category;

	/**
	 * @ORM\Column(type="date")
	 * @Assert\NotBlank(groups={"create", "update"})
	 */
	private $releaseDate;

	/**
	 * @ORM\Column
	 * @Assert\Image(minHeight=300, minWidth=750, groups={"create"})
	 */
	private $mainPicture;
	
	private $tmpPicture;

	/**
     * @ORM\Column(options={"default" : "LOCAL_DATABASE"})
     */
	private $dataSource;


	// Getter / Setters //
	public function getid() {
		return $this->id;
	}

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
	
	public function setCountry($country) {
		$this->country = $country;
	}

	public function getRealisator() {
		return $this->realisator;
	}

	public function setRealisator($realisator) {
		$this->realisator = $realisator;
	}

	public function getAuthor () {
		return $this->author;
	}
	
	public function setAuthor (User $author) {
		$this->author = $author;
	}

	public function getCategory () {
		return $this->category;
	}
	
	public function setCategory ($category) {
		$this->category = $category;
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

	public function getTmpPicture () {
		return $this->tmpPicture;
	}
	
	public function setTmpPicture ($tmpPicture) {
		$this->tmpPicture = $tmpPicture;
	}

	public function getDataSource() {
		return $this->dataSource;
	}

	public function setDataSource($dataSource) {
		$this->dataSource = $dataSource;
 	}
	// Getter / Setters //
}
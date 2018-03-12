<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;

use AppBundle\Entity\User;

use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ShowRepository")
 * @ORM\Table(name="s_shows")
 *
 * @JMS\ExclusionPolicy("all")
 */
class Show {

	// Data source const
	const DATA_SOURCE_OMDB = 'OMDB';
	const DATA_SOURCE_DB_API = 'API_LOCAL_DATABASE';
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
	 *
	 * @JMS\Expose
	 * @JMS\Groups({"show"})
	 *
	 * @SWG\Property(description="Unique name of the show.")
	 */
	private $name;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank(groups={"create", "update"})
	 *
	 * @JMS\Expose
	 * @JMS\Groups({"show"})
	 *
	 * @SWG\Property(description="Description of the show.")
	 */
	private $abstract;

	/**
	 * @ORM\Column
	 * @Assert\NotBlank(groups={"create", "update"})
	 *
	 * @JMS\Expose
	 * @JMS\Groups({"show"})
	 *
	 * @SWG\Property(description="Code country of the show (Example : US, FR, EN).")
	 */
	private $country;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank(groups={"create", "update"})
	 *
	 * @JMS\Expose
	 * @JMS\Groups({"show"})
	 *
	 * @SWG\Property(description="Realisator of the show.")
	 */
	private $realisator;

	/**
     * @Assert\NotBlank(groups={"create","update"})
     * @ORM\ManyToOne(targetEntity="User", inversedBy="shows")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
	 * @JMS\Expose
	 * @JMS\Groups({"show"})
	 *
	 * @Accessor(getter="getAuthorAsArray")
 	 * @Type("array")
 	 *
	 * @SWG\Property(description="User of the show (See user fullname model).")
     */
	private $author;

	/**
	 * @Assert\NotBlank(groups={"create", "update"})
	 * @ORM\ManyToOne(targetEntity="Category")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
	 *
	 * @JMS\Expose
	 * @JMS\Groups({"show"})
	 *
	 * @Accessor(getter="getCategoryAsArray")
 	 * @Type("array")
 	 *
	 * @SWG\Property(description="Category name of the show.")
	 */
	private $category;

	/**
	 * @ORM\Column(type="date")
	 * @Assert\NotBlank(groups={"create", "update"})
	 *
	 * @JMS\Expose
	 * @JMS\Groups({"show"})
	 *
	 * @SWG\Property(description="Release date of the show (Example : 2018-01-01).")
	 */
	private $releaseDate;

	/**
	 * @ORM\Column
	 * @Assert\Image(minHeight=300, minWidth=750, groups={"create"})
	 *
	 * @JMS\Expose
	 *
	 * @SWG\Property(description="Picture of the show (http url).")
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

 	// List method for Category & Author properties
	public function getAuthorAsArray()
	{
		return (array)$this->author->getFullname();
	}

	public function getCategoryAsArray()
	{
    return (array)$this->category->getName();
	}

	// Update method
 	public function update(Show $show) {

 		if($show->getName() != null) {
             $this->name = $show->getName();
        }

        if($show->getAbstract() != null) {
             $this->abstract = $show->getAbstract();
        }

        if($show->getCountry() != null) {
             $this->country = $show->getCountry();
        }

        if($show->getRealisator() != null) {
             $this->realisator = $show->getRealisator();
        }

        if($show->getReleaseDate() != null) {
             $this->releaseDate = $show->getReleaseDate();
        }

        if($show->getMainPicture() != null) {
             $this->mainPicture = $show->getMainPicture();
        }
 	}
}
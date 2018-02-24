<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table
 * @UniqueEntity("email", groups={"user_create"})
 *
 * @JMS\ExclusionPolicy("all")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
     *
     * @JMS\Groups({"user", "user_create"})
	 */
	private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @JMS\Expose
     * @JMS\Groups({"user", "show",  "user_update"})
     */
    private $fullname;

    /**
     * @ORM\Column(type="json_array")
     *
     * @Assert\NotBlank(groups={"user_create"})
     *
     * @JMS\Type("string")
     * @JMS\Expose
     * @JMS\Groups({"user_create", "user_update"})
     */
    private $roles;
    
    /**
     * @ORM\Column
     *
     * @Assert\Email
     *
     * @JMS\Expose
     * @JMS\Groups({"user", "user_update"})
     */
    private $email;

	/**
     * @ORM\Column
     *
     * @Assert\NotBlank(groups={"user_create"})
     *
     * @JMS\Expose
     * @JMS\Groups({"user_create", "user_update"})
     */
    private $password;

	/**
     * @ORM\OneToMany(targetEntity="Show", mappedBy="author")
     */
    private $shows;

    public function __construct() {
        $this->shows = new ArrayCollection();
    }

    /* GETTEURS / SETTEURS */
    public function getid() {
    	return $this->id;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function getRoles() {
    	return $this->roles;
    }

    public function setRoles($roles) {
        $this->roles = $roles;
    }

    public function getEmail() {
    	return $this->email;
    }

    public function setEmail($email) {
    	$this->email = $email;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function setUsername($email)
    {
        $this->email = $email;
    }

    public function getPassword() {
       return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getSalt() {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials() {
        // TODO: Implement eraseCredentials() method.
    }

    public function addShow(Show $show) {
    	if(!$this->shows->contains($show)) $this->shows->add($show);
    }

    public function removeShow(Show $show) {
    	$this->shows->remove($show);
    }

    public function getShows() {
        return $this->shows;
    }

    public function setShows($shows) {
        $this->shows = $shows;
    }

    // Update Method
    public function update(User $user) {
    
        if($user->getFullname() != null) {
             $this->fullname = $user->getFullname();
        }

        if($user->getEmail() != null) {
             $this->email = $user->getEmail();
        }

        if($user->getRoles() != null) {
             $this->setRoles(explode(', ', $user->getRoles()));
        } 
    }
}
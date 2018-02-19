<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $fullname;

    private $roles;
    
    /**
     * @ORM\Column
     * @Assert\Email
     */
    private $email;

	/**
     * @ORM\Column
     */
    private $password;


    // GETTEURS / SETTEURS 
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
        return ['ROLE_ADMIN'];
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

}
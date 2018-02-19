<?php

namespace AppBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('fullname')
			->add('email')
			->add('password', RepeatedType::class, array(
    				'type' => PasswordType::class,
    				'invalid_message' => 'The password fields must match.',
    				'options' => array('attr' => array('class' => 'password-field')),
    				'required' => true,
    				'first_options'  => array('label' => 'Password'),
    				'second_options' => array('label' => 'Repeat Password'),
    		));
	}
} 
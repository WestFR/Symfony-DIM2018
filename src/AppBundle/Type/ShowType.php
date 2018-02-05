<?php

namespace AppBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ShowType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('name')
			->add('category')
			->add('abstract')
			->add('country', CountryType::class)
			->add('author')
			->add('releaseDate')
			->add('mainPicture', FileType::class);
	}

} 
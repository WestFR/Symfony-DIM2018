<?php

namespace AppBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Entity\Category;

class ShowType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('name')
			->add('category', EntityType::class, [
				'class' => Category::class,
				'choice_label' => 'name',
			])
			->add('abstract')
			->add('country', CountryType::class, ['preferred_choices' => array('FR','US')])
			->add('author')
			->add('releaseDate', DateTimeType::class)
			->add('mainPicture', FileType::class);
	}

} 
<?php

namespace AppBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Entity\Media;

class MediaType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('file', FileType::class);
	}

	public function configureOptions(OptionsResolver $resolver) {
		
		$resolver->setDefaults([
			'data_class' => Media::class
		]);
	}

} 
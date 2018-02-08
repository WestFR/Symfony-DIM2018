<?php

namespace AppBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Entity\Show;

class SearchType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('name');
	}

} 
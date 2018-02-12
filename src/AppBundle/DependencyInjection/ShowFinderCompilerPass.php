<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

use AppBundle\ShowFinder\ShowFinder;


class ShowFinderCompilerPass implements CompilerPassInterface {

	public function process(ContainerBuilder $container) {
		
		$showFinderDefinition = $container->findDefinition(ShowFinder::class);

		$showFinderTaggedServices = $container->findTaggedServiceIds('show.finder');

		foreach ($showFinderTaggedServices as $showFinderTaggedServiceId => $showFinderTags) {
			
			$serviceReference = new Reference($showFinderTaggedServiceId);

			$showFinderDefinition->addMethodCall('addFinder', [$serviceReference]);
		}


	}
}
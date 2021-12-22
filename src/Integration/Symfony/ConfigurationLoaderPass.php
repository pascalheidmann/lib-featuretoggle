<?php
declare(strict_types = 1);

namespace FeatureToggle\Integration\Symfony;

use FeatureToggle\FeatureToggleManagerInterface;
use FeatureToggle\Repository\RepositoryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConfigurationLoaderPass implements CompilerPassInterface {
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container): void {
        $manager = $container->getDefinition(FeatureToggleManagerInterface::class);
        if ($manager) {
            $repositories = $this->findAndSortTaggedServices(RepositoryInterface::class, $container);
            foreach ($repositories as $repository) {
                $manager->addMethodCall('addRepository', [$repository]);
            }
        }
    }
}
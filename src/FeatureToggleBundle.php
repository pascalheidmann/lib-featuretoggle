<?php
declare(strict_types = 1);

namespace FeatureToggle;

use FeatureToggle\Integration\Symfony\ConfigurationLoaderPass;
use FeatureToggle\Repository\RepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FeatureToggleBundle extends Bundle {
    public function build(ContainerBuilder $container): void {
        parent::build($container);

        $container
            ->registerForAutoconfiguration(RepositoryInterface::class)
            ->addTag(RepositoryInterface::class);
        $container->addCompilerPass(new ConfigurationLoaderPass());
    }
}
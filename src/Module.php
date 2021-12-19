<?php
declare(strict_types = 1);

namespace FeatureToggle;

use Laminas\ModuleManager\ModuleManager;

class Module {
    /**
     * Return default configuration for laminas-mvc applications.
     *
     * @return array{service_manager: mixed}
     */
    public function getConfig(): array {
        $provider = new ConfigProvider();

        return [
            'service_manager' => $provider(),
        ];
    }
}
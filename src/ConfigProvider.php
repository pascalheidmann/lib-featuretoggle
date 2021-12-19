<?php
declare(strict_types = 1);

namespace FeatureToggle;

class ConfigProvider {
    /**
     * Return configuration for this component.
     *
     * @return array{dependencies: mixed}
     */
    public function __invoke(): array {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return dependency mappings for this component.
     *
     * @return array<string, mixed>
     */
    private function getDependencyConfig(): array {
        return [
            'aliases' => [],
            'factories' => [],
        ];
    }
}
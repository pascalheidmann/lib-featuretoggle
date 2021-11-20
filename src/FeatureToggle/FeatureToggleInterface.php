<?php
declare(strict_types=1);

namespace FeatureToggle\FeatureToggle;

interface FeatureToggleInterface
{
	public function getKey(): string;

	/**
	 * @param array<string, mixed> $data
	 *
	 * @return bool
	 */
	public function evaluate(array $data = []): bool;
}
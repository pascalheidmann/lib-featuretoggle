<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle;

interface FeatureToggleRepository
{
	public function hasToggle(string $key): bool;

	public function get(string $key): ?FeatureToggle;
}
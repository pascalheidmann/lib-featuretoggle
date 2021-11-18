<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Repository;

use PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;

interface RepositoryInterface
{
	public function hasToggle(string $key): bool;

	public function get(string $key): ?FeatureToggle;
}
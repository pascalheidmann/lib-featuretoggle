<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Repository;

use JetBrains\PhpStorm\Pure;
use PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;

class ArrayFeatureToggleRepository implements FeatureToggleRepositoryInterface
{
	/** @var FeatureToggle[] */
	private array $featureToggles;

	public function __construct(FeatureToggle ...$featureToggles)
	{
		$this->featureToggles = $featureToggles;
	}

	#[Pure]
	public function hasToggle(string $key): bool
	{
		return $this->get($key) !== null;
	}

	#[Pure]
	public function get(string $key): ?FeatureToggle
	{
		foreach ($this->featureToggles as $featureToggle) {
			if ($featureToggle->getKey() === $key) {
				return $featureToggle;
			}
		}
		return null;
	}
}
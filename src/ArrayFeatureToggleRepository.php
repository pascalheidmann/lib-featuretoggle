<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle;

class ArrayFeatureToggleRepository implements FeatureToggleRepository
{
	/** @var FeatureToggle[] */
	private array $featureToggles;

	public function __construct(FeatureToggle ...$featureToggles)
	{
		$this->featureToggles = $featureToggles;
	}

	public function hasToggle(string $key): bool
	{
		return $this->get($key) !== null;
	}

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
<?php
declare(strict_types=1);

namespace FeatureToggle\Repository;

use FeatureToggle\Exception\DuplicateFeatureToggleInRepositoryException;
use FeatureToggle\FeatureToggle\FeatureToggle;

class ArrayRepository implements RepositoryInterface
{
	/** @var array<string, FeatureToggle> */
	private array $featureToggles = [];

	public function __construct(FeatureToggle ...$featureToggles)
	{
		foreach ($featureToggles as $featureToggle) {
			$this->addToggle($featureToggle);
		}
	}

	public function addToggle(FeatureToggle $featureToggle): RepositoryInterface
	{
		if ($this->hasToggle($featureToggle->getKey())) {
			throw new DuplicateFeatureToggleInRepositoryException(self::class, $featureToggle->getKey());
		}
		$this->featureToggles[$featureToggle->getKey()] = $featureToggle;

		return $this;
	}

	public function hasToggle(string $key): bool
	{
		return isset($this->featureToggles[$key]);
	}

	public function get(string $key): ?FeatureToggle
	{
		return $this->featureToggles[$key] ?? null;
	}
}
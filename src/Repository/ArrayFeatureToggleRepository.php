<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Repository;

use JetBrains\PhpStorm\Pure;
use PascalHeidmann\FeatureToggle\Exception\DuplicateFeatureToggleInRepositoryException;
use PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;

class ArrayFeatureToggleRepository implements FeatureToggleRepositoryInterface
{
	/** @var array<string, FeatureToggle> */
	private array $featureToggles = [];

	public function __construct(FeatureToggle ...$featureToggles)
	{
		foreach ($featureToggles as $featureToggle) {
			$this->addToggle($featureToggle);
		}
	}

	public function addToggle(FeatureToggle $featureToggle): FeatureToggleRepositoryInterface
	{
		if ($this->hasToggle($featureToggle->getKey())) {
			throw new DuplicateFeatureToggleInRepositoryException(self::class, $featureToggle->getKey());
		}
		$this->featureToggles[$featureToggle->getKey()] = $featureToggle;

		return $this;
	}

	#[Pure]
	public function hasToggle(string $key): bool
	{
		return isset($this->featureToggles[$key]);
	}

	#[Pure]
	public function get(string $key): ?FeatureToggle
	{
		return $this->featureToggles[$key] ?? null;
	}
}
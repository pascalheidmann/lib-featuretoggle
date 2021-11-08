<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Combination;

use PascalHeidmann\FeatureToggle\Type\FeatureToggle;

class AnyFeatureToggle implements FeatureToggle
{
	private string $key;
	/** @var FeatureToggle[] */
	private array $featureToggles;

	public function __construct(string $key, FeatureToggle ...$featureToggles)
	{
		$this->key = $key;
		$this->featureToggles = $featureToggles;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function evaluate(array $data = []): bool
	{
		foreach ($this->featureToggles as $featureToggle) {
			if ($featureToggle->evaluate($data)) {
				return true;
			}
		}
		return false;
	}
}
<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleNotFoundException;

class FeatureToggleManager
{
	/** @var FeatureToggleRepository[] */
	private array $featureToggleRepository;

	public function __construct(FeatureToggleRepository ...$featureToggleRepository)
	{
		$this->featureToggleRepository = $featureToggleRepository;
	}

	public function get(string $key, array $data): bool
	{
		foreach ($this->featureToggleRepository as $repository) {
			$featureToggle = $repository->get($key);

			if ($featureToggle !== null) {
				return $featureToggle->evaluate($data);
			}
		}
		throw new FeatureToggleNotFoundException($key);
	}
}
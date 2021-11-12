<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Condition\Combination;

use PascalHeidmann\FeatureToggle\Condition\ConditionInterface;

class ConditionAll implements ConditionInterface
{
	/** @var ConditionInterface[] */
	private array $featureToggles;

	public function __construct(ConditionInterface ...$featureToggles)
	{
		$this->featureToggles = $featureToggles;
	}

	public function evaluate(array $data = []): bool
	{
		foreach ($this->featureToggles as $featureToggle) {
			if (!$featureToggle->evaluate($data)) {
				return false;
			}
		}
		return true;
	}
}
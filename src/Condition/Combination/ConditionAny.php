<?php
declare(strict_types=1);

namespace FeatureToggle\Condition\Combination;

use FeatureToggle\Condition\ConditionInterface;

class ConditionAny implements ConditionInterface, ConditionContainer
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
			if ($featureToggle->evaluate($data)) {
				return true;
			}
		}
		return false;
	}
}
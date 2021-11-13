<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Condition;

class TrueCondition implements ConditionInterface
{
	public function evaluate(array $data = []): bool
	{
		return true;
	}
}
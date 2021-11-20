<?php
declare(strict_types=1);

namespace FeatureToggle\Condition;

class TrueCondition implements ConditionInterface
{
	public function evaluate(array $data = []): bool
	{
		return true;
	}
}
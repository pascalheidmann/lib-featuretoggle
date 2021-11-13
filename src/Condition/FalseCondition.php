<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Condition;

class FalseCondition implements ConditionInterface
{
	public function evaluate(array $data = []): bool
	{
		return false;
	}
}
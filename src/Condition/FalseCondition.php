<?php
declare(strict_types=1);

namespace FeatureToggle\Condition;

class FalseCondition implements ConditionInterface
{
	public function evaluate(array $data = []): bool
	{
		return false;
	}
}
<?php
declare(strict_types=1);

namespace FeatureToggle\Condition;

class RandomCondition implements ConditionInterface
{
	public function evaluate(array $data = []): bool
	{
		return random_int(0, 1) === 1;
	}
}
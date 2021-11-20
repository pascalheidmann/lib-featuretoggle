<?php
declare(strict_types=1);

namespace FeatureToggle\Condition;

class StaticCondition implements ConditionInterface
{
	private bool $value;

	public function __construct(bool $value)
	{
		$this->value = $value;
	}

	public function evaluate(array $data = []): bool
	{
		return $this->value;
	}
}
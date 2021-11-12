<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Condition;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;

class PercentageCondition implements ConditionInterface
{
	public const KEY = 'percentage';

	private float $threshold;

	public function __construct(float $threshold)
	{
		$this->threshold = $threshold;
	}

	public function evaluate(array $data = []): bool
	{
		$percentage = $data[self::KEY] ?? null;
		if (!is_float($percentage) && !is_int($percentage)) {
			throw new FeatureToggleRequiredParameterMissingException(self::class, self::KEY);
		}
		return $percentage <= $this->threshold;
	}
}
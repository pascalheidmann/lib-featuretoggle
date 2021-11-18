<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Condition;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;

class MinimumNumberCondition implements ConditionInterface
{
	private float $threshold;
	private string $key;

	public function __construct(float $threshold, string $key)
	{
		$this->threshold = $threshold;
		$this->key = $key;
	}

	public function evaluate(array $data = []): bool
	{
		$percentage = $data[$this->key] ?? null;
		if (!is_float($percentage) && !is_int($percentage)) {
			throw new FeatureToggleRequiredParameterMissingException(self::class, $this->key);
		}
		return $percentage >= $this->threshold;
	}
}
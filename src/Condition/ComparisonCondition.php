<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Condition;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;
use function is_float;
use function is_int;

class ComparisonCondition implements ConditionInterface
{
	private string $dataKey;
	/** @var mixed */
	private $value;

	public function __construct(string $dataKey, $value)
	{
		$this->dataKey = $dataKey;
		$this->value = $value;
	}

	public function evaluate(array $data = []): bool
	{
		$value = $data[$this->dataKey] ?? null;
		if (!is_float($value) && !is_int($value)) {
			throw new FeatureToggleRequiredParameterMissingException(self::class, $this->dataKey);
		}
		return $value === $this->value;
	}
}
<?php
declare(strict_types=1);

namespace FeatureToggle\Condition;

use FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;
use function is_float;
use function is_int;

/**
 * @template T
 */
class ComparisonCondition implements ConditionInterface
{
	private string $dataKey;
	/** @var T */
	private $value;

	/**
	 * @param T $value
	 */
	public function __construct(string $dataKey, $value)
	{
		$this->dataKey = $dataKey;
		$this->value = $value;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	public function evaluate(array $data = []): bool
	{
		if (!isset($data[$this->dataKey])) {
			throw new FeatureToggleRequiredParameterMissingException(self::class, $this->dataKey);
		}
		return $data[$this->dataKey] === $this->value;
	}
}
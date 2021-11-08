<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Type;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;

class ComparisonFeatureToggle implements FeatureToggle
{
	private string $key;
	private string $dataKey;
	/** @var mixed */
	private $value;

	public function __construct(string $key, string $dataKey, $value)
	{
		$this->key = $key;
		$this->dataKey = $dataKey;
		$this->value = $value;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function evaluate(array $data = []): bool
	{
		$value = $data[$this->dataKey] ?? null;
		if (!is_float($value) && !is_int($value)) {
			throw new FeatureToggleRequiredParameterMissingException($this->key, $this->dataKey);
		}
		return $value === $this->value;
	}
}
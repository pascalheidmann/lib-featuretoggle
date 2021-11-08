<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Type;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;

class PercentageFeatureToggle implements FeatureToggle
{
	public const KEY = 'percentage';

	private string $key;
	private float $threshold;

	public function __construct(string $key, float $threshold)
	{
		$this->key = $key;
		$this->threshold = $threshold;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function evaluate(array $data = []): bool
	{
		$percentage = $data[self::KEY] ?? null;
		if (!is_float($percentage) && !is_int($percentage)) {
			throw new FeatureToggleRequiredParameterMissingException($this->key, self::KEY);
		}
		return $percentage <= $this->threshold;
	}
}
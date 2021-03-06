<?php
declare(strict_types=1);

namespace FeatureToggle\FeatureToggle;

use FeatureToggle\Condition\ConditionInterface;

class FeatureToggle implements FeatureToggleInterface
{
	private string $key;
	private ConditionInterface $condition;

	public function __construct(string $key, ConditionInterface $condition)
	{
		$this->key = $key;
		$this->condition = $condition;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function evaluate(array $data = []): bool
	{
		return $this->condition->evaluate($data);
	}
}
<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Type;

class StaticFeatureToggle implements FeatureToggle
{
	private string $key;
	private bool $value;

	public function __construct(string $key, bool $value)
	{
		$this->key = $key;
		$this->value = $value;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function evaluate(array $data = []): bool
	{
		return $this->value;
	}
}
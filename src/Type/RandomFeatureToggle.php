<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Type;

class RandomFeatureToggle implements FeatureToggle
{
	private string $key;

	public function __construct(string $key)
	{
		$this->key = $key;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function evaluate(array $data = []): bool
	{
		return rand(0, 1) === 1;
	}
}
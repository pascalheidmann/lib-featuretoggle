<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Type;

interface FeatureToggle
{
	public function getKey(): string;

	public function evaluate(array $data = []): bool;
}
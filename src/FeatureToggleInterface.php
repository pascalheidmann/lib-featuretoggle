<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle;

interface FeatureToggleInterface
{
	public function getKey(): string;

	public function evaluate(array $data = []): bool;
}
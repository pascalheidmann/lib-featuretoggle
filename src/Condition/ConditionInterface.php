<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Condition;

interface ConditionInterface
{
	/**
	 * @param array<string, mixed> $data
	 *
	 * @return bool
	 */
	public function evaluate(array $data = []): bool;
}
<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Condition;

interface ConditionInterface
{
	public function evaluate(array $data = []): bool;
}
<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\FeatureToggle;

use JetBrains\PhpStorm\Pure;
use PascalHeidmann\FeatureToggle\Condition\StaticCondition;

/**
 * Shortcut for generic feature toggle which always evaluate to $value
 */
class StaticFeatureToggle extends FeatureToggle
{
	
	public function __construct(string $key, bool $value)
	{
		parent::__construct($key, new StaticCondition($value));
	}
}
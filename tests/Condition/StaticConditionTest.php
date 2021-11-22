<?php
declare(strict_types=1);

namespace FeatureToggle\Tests\Condition;

use FeatureToggle\Condition\StaticCondition;
use PHPUnit\Framework\TestCase;

class StaticConditionTest extends TestCase
{
	public function testEvaluate(): void
	{
		self::assertTrue((new StaticCondition(true))->evaluate());
		self::assertFalse((new StaticCondition(false))->evaluate());
	}
}

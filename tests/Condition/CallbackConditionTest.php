<?php
declare(strict_types=1);

namespace FeatureToggle\Tests\Condition;

use FeatureToggle\Condition\CallbackCondition;
use PHPUnit\Framework\TestCase;

class CallbackConditionTest extends TestCase
{
	public function testEvaluate(): void
	{
		$trueCallback = new CallbackCondition(static fn(): bool => true);
		self::assertTrue($trueCallback->evaluate());

		$falseCallback = new CallbackCondition(static fn(): bool => false);
		self::assertFalse($falseCallback->evaluate());

		$called = false;
		$calledCallback = new CallbackCondition(static function() use (&$called): bool {
			$called = true;
			return true;
		});
		$calledCallback->evaluate();
		self::assertTrue($called);
	}
}

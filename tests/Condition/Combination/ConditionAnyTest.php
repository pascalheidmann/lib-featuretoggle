<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggleTests\Condition\Combination;

use PascalHeidmann\FeatureToggle\Condition\Combination\ConditionAny;
use PascalHeidmann\FeatureToggle\Condition\StaticCondition;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PascalHeidmann\FeatureToggle\Condition\Combination\ConditionAny
 */
final class ConditionAnyTest extends TestCase
{
	/**
	 * @test
	 * @dataProvider conditions
	 */
	public function itWillEvaluate(bool $expected, ConditionAny $condition): void
	{
		self::assertEquals($expected, $condition->evaluate());
	}

	/**
	 * @return iterable<string, array{0: bool, 1: ConditionAny}>
	 */
	public function conditions(): iterable
	{
		$positive = new StaticCondition(true);
		$negative = new StaticCondition(false);

		yield 'none' => [
			false,
			new ConditionAny(),
		];

		yield 'positive' => [
			true,
			new ConditionAny($positive),
		];

		yield 'negative' => [
			false,
			new ConditionAny($negative),
		];

		yield 'negative + positive #1' => [
			true,
			new ConditionAny($positive, $negative),
		];

		yield 'negative + positive #2' => [
			true,
			new ConditionAny($negative, $positive),
		];

		yield 'negative + positive #3' => [
			true,
			new ConditionAny($negative, $negative, $positive),
		];
	}
}
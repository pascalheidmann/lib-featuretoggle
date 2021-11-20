<?php
declare(strict_types=1);

namespace FeatureToggle\Tests\Condition\Combination;

use FeatureToggle\Condition\Combination\ConditionAll;
use FeatureToggle\Condition\StaticCondition;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FeatureToggle\Condition\Combination\ConditionAll
 */
final class ConditionAllTest extends TestCase
{
	/**
	 * @test
	 * @dataProvider conditions
	 */
	public function itWillEvaluate(bool $expected, ConditionAll $condition): void
	{
		self::assertEquals($expected, $condition->evaluate());
	}

	/**
	 * @return iterable<string, array{0:bool, 1: ConditionAll}>
	 */
	public function conditions(): iterable
	{
		$positive = new StaticCondition(true);
		$negative = new StaticCondition(false);

		yield 'none' => [
			true,
			new ConditionAll(),
		];

		yield 'positive' => [
			true,
			new ConditionAll($positive),
		];

		yield 'negative' => [
			false,
			new ConditionAll($negative),
		];

		yield 'negative + positive #1' => [
			false,
			new ConditionAll($positive, $negative),
		];

		yield 'negative + positive #2' => [
			false,
			new ConditionAll($negative, $positive),
		];

		yield 'negative + positive #3' => [
			false,
			new ConditionAll($negative, $negative, $positive),
		];
	}
}
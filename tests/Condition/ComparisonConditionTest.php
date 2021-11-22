<?php
declare(strict_types=1);

namespace FeatureToggle\Tests\Condition;

use FeatureToggle\Condition\ComparisonCondition;
use FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;
use PHPUnit\Framework\TestCase;

class ComparisonConditionTest extends TestCase
{
	/**
	 * @param bool  $expected
	 * @param mixed $data
	 * @param mixed $comparison
	 *
	 * @test
	 * @dataProvider dataProvider
	 */
	public function itEvaluatesCorrectly(bool $expected, $data, $comparison): void
	{
		$condition = new ComparisonCondition('key', $comparison);
		self::assertEquals($expected, $condition->evaluate(['key' => $data]));
	}

	/**
	 * @return iterable<string, array{0: bool, 1: mixed, 2: mixed}>
	 */
	public function dataProvider(): iterable
	{
		yield 'string #1' => [
			true,
			'foo',
			'foo',
		];

		yield 'string #2' => [
			false,
			'foo',
			'bar',
		];

		yield 'empty array' => [
			true,
			[],
			[],
		];

		yield 'array #2' => [
			false,
			['foo'],
			['bar'],
		];

		yield 'array #3' => [
			false,
			['foo', 'bar'],
			['bar', 'foo'],
		];

		yield 'array #4' => [
			false,
			[1 => 'foo', 2 => 'bar'],
			[2 => 'bar', 1 => 'foo'],
		];

		yield 'mixed' => [
			false,
			'foo',
			123,
		];
	}

	/**
	 * @test
	 */
	public function itFailsOnUnknownKey(): void
	{
		$condition = new ComparisonCondition('key', 'foo');
		$this->expectException(FeatureToggleRequiredParameterMissingException::class);
		self::assertFalse($condition->evaluate(['bar' => 'foo']));
	}
}

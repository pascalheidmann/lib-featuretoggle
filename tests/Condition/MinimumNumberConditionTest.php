<?php
declare(strict_types=1);

namespace FeatureToggle\Tests\Condition;

use JetBrains\PhpStorm\ArrayShape;
use FeatureToggle\Condition\MinimumNumberCondition;
use FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;
use PHPUnit\Framework\TestCase;
use stdClass;

class MinimumNumberConditionTest extends TestCase
{
	/**
	 * @test
	 */
	public function itEvaluatesCorrectly(): void
	{
		$tests = [
			[false, 0, 10],
			[true, 10, 10],
			[true, 11, 10],
			[false, 0.0, 10.1],
			[false, 10.0, 10.1],
			[true, 10.1, 10.1],
			[true, 11.0, 10.1],
		];

		foreach ($tests as [$expected, $value, $threshold]) {
			$condition = new MinimumNumberCondition($threshold, 'foo');
			self::assertEquals($expected, $condition->evaluate(['foo' => $value]));
		}
	}

	/**
	 * @test
	 */
	public function itThrowsExceptionOnMissingKey(): void
	{
		$condition = new MinimumNumberCondition(10, 'foo');
		$this->expectException(FeatureToggleRequiredParameterMissingException::class);
		$condition->evaluate();
	}

	/**
	 * @test
	 * @dataProvider invalidDataTypes
	 *
	 * @param mixed $value
	 */
	public function itFailsOnInvalidDataType($value): void
	{
		$condition = new MinimumNumberCondition(10, 'foo');
		$this->expectException(FeatureToggleRequiredParameterMissingException::class);
		$condition->evaluate(['foo' => $value]);
	}

	/**
	 * @return array<string, array{0: mixed}>
	 */
	public function invalidDataTypes(): array
	{
		return [
			'string' => ['foo'],
			'null' => [null],
			'false' => [false],
			'true' => [true],
			'empty array' => [[]],
			'array' => [[1,2]],
			'object' => [new stdClass()],
			'callable' => [fn(): bool => true],
		];
	}
}

<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggleTests\Repository;

use PascalHeidmann\FeatureToggle\Condition\Combination\ConditionAll;
use PascalHeidmann\FeatureToggle\Condition\Combination\ConditionAny;
use PascalHeidmann\FeatureToggle\Condition\FalseCondition;
use PascalHeidmann\FeatureToggle\Condition\MinimumNumberCondition;
use PascalHeidmann\FeatureToggle\Condition\StaticCondition;
use PascalHeidmann\FeatureToggle\Condition\TrueCondition;
use PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;
use PascalHeidmann\FeatureToggle\Repository\LazyArrayRepository;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PascalHeidmann\FeatureToggle\Repository\LazyArrayRepository
 */
class LazyArrayRepositoryTest extends TestCase
{
	/**
	 * @test
	 * @dataProvider featureToggles
	 */
	public function itReturnsFeatureToggle(string $key, ?FeatureToggle $toggle): void
	{
		$repository = $this->getLazyArrayRepository();

		self::assertEquals($toggle instanceof FeatureToggle, $repository->hasToggle($key));
		self::assertEquals($toggle, $repository->get($key));
	}

	/**
	 * @return LazyArrayRepository
	 */
	private function getLazyArrayRepository(): LazyArrayRepository
	{
		return new LazyArrayRepository([
			'implicit-all' => [
				[
					[
						MinimumNumberCondition::class,
						[10, 'percentage'],
					],
					[
						StaticCondition::class,
						[true],
					],
				],
			],
			ConditionAll::class => [
				[
					[
						MinimumNumberCondition::class,
						[10, 'percentage'],
					],
					[
						StaticCondition::class,
						[true],
					],
				],
				ConditionAll::class,
			],
			ConditionAny::class => [
				[
					[
						TrueCondition::class,
					],
					[
						FalseCondition::class,
					],
				],
				ConditionAny::class,
			],
			'feature-toggle' => new FeatureToggle('feature-toggle', new TrueCondition()),
		]);
	}

	/**
	 * @return array<int, array{0: string, 1: FeatureToggle|null}>
	 */
	public function featureToggles(): array
	{
		$conditionAll = new ConditionAll(new MinimumNumberCondition(10, 'percentage'), new StaticCondition(true));
		$conditionAny = new ConditionAny(new TrueCondition(), new FalseCondition());

		return [
			['implicit-all', new FeatureToggle('implicit-all', $conditionAll)],
			[ConditionAll::class, new FeatureToggle(ConditionAll::class, $conditionAll)],
			[ConditionAny::class, new FeatureToggle(ConditionAny::class, $conditionAny)],
			['feature-toggle', new FeatureToggle('feature-toggle', new TrueCondition())],
			['other', null],
		];
	}
}

<?php
declare(strict_types=1);

namespace Tests\PascalHeidmann\FeatureToggle;

use PascalHeidmann\FeatureToggle\Condition\Combination\ConditionAny;
use PascalHeidmann\FeatureToggle\Condition\MinimumNumberCondition;
use PascalHeidmann\FeatureToggle\Condition\PercentageCondition;
use PascalHeidmann\FeatureToggle\Condition\StaticCondition;
use PascalHeidmann\FeatureToggle\Exception\FeatureToggleNotFoundException;
use PascalHeidmann\FeatureToggle\Exception\FeatureToggleRequiredParameterMissingException;
use PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;
use PascalHeidmann\FeatureToggle\FeatureToggle\StaticFeatureToggle;
use PascalHeidmann\FeatureToggle\FeatureToggleManager;
use PascalHeidmann\FeatureToggle\Repository\ArrayRepository;
use PHPUnit\Framework\TestCase;

class FeatureToggleManagerTest extends TestCase
{
	/**
	 * @test
	 */
	public function itReturnsCorrectFeatureToggleState(): void
	{
		$featureToggle = new FeatureToggle('my-feature-toggle', new StaticCondition(true));
		$repository = new ArrayRepository($featureToggle);
		$featureToggleManager = new FeatureToggleManager($repository);

		self::assertEquals(true, $featureToggleManager->get('my-feature-toggle')); // true
	}

	/**
	 * @test
	 */
	public function itTakesFirstRepositoryInstanceWithKey(): void
	{
		$featureToggle1 = new FeatureToggle('my-feature-toggle', new StaticCondition(true));
		$repository = new ArrayRepository($featureToggle1);

		$featureToggle2 = new StaticFeatureToggle('my-feature-toggle', false);
		$repository2 = new ArrayRepository($featureToggle2);

		$featureToggleManager = new FeatureToggleManager($repository, $repository2);

		self::assertEquals(true, $featureToggleManager->get('my-feature-toggle')); // true
	}

	/**
	 * @test
	 */
	public function itWillTriggerAnExceptionCausedByMissingFeatureToggle(): void
	{
		$this->expectException(FeatureToggleNotFoundException::class);
		(new FeatureToggleManager())->get('my-non-existing-toggle');
	}

	/**
	 * @test
	 */
	public function itWillAddFeatureToggleRepository(): void
	{
		$featureToggleManager = new FeatureToggleManager();
		try {
			$featureToggleManager->get('my-toggle');
		} catch (FeatureToggleNotFoundException $exception) {
			self::assertEquals(
				sprintf('Feature toggle with key "%s" not found!', 'my-toggle'),
				$exception->getMessage()
			);
		}

		$repository = new ArrayRepository(new StaticFeatureToggle('my-toggle', true));
		$featureToggleManager->addRepository($repository);

		self::assertEquals(true, $featureToggleManager->get('my-toggle'));
	}

	/**
	 * @test
	 */
	public function itUsesDefaultData(): void
	{
		$manager = new FeatureToggleManager(
			new ArrayRepository(
				new FeatureToggle(
					'my-toggle',
					new ConditionAny(
						new MinimumNumberCondition(10, 'percentage1'),
						new MinimumNumberCondition(10, 'percentage2'),
					)
				)
			)
		);

		self::assertEquals(false, $manager->get('my-toggle', ['percentage1' => 0, 'percentage2' => 0]));
		self::assertEquals(true, $manager->get('my-toggle', ['percentage1' => 10, 'percentage2' => 0]));

		$manager->addDefaultData(['percentage1' => 10]);
		self::assertEquals(false, $manager->get('my-toggle', ['percentage1' => 0, 'percentage2' => 0]));
		self::assertEquals(true, $manager->get('my-toggle', ['percentage1' => 10, 'percentage2' => 0]));
		self::assertEquals(true, $manager->get('my-toggle', ['percentage2' => 0]));

		$manager->resetDefaultData();
		$this->expectException(FeatureToggleRequiredParameterMissingException::class);
		$manager->get('my-toggle', ['percentage2' => 0]);
	}
}

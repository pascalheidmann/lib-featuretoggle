<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Tests;

use PascalHeidmann\FeatureToggle\Condition\StaticCondition;
use PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;
use PascalHeidmann\FeatureToggle\FeatureToggleManager;
use PascalHeidmann\FeatureToggle\Repository\ArrayFeatureToggleRepository;
use PHPUnit\Framework\TestCase;

class FeatureToggleManagerTest extends TestCase
{
	/**
	 * @return void
	 * @test
	 */
	public function itReturnsCorrectFeatureToggleState(): void
	{
		$featureToggle = new FeatureToggle('my-feature-toggle', new StaticCondition(true));
		$repository = new ArrayFeatureToggleRepository($featureToggle);
		$featureToggleManager = new FeatureToggleManager($repository);

		self::assertEquals(true, $featureToggleManager->get('my-feature-toggle')); // true
	}
}

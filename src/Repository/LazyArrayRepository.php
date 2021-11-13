<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Repository;

use PascalHeidmann\FeatureToggle\Condition\Combination\ConditionAll;
use PascalHeidmann\FeatureToggle\Condition\Combination\ConditionAny;
use PascalHeidmann\FeatureToggle\Condition\ConditionInterface;
use PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;

class LazyArrayRepository implements RepositoryInterface
{
	private const COMBINATION_ALIAS = [
		ConditionAll::class => ConditionAll::class,
		ConditionAny::class => ConditionAny::class,
		'all' => ConditionAll::class,
		'any' => ConditionAny::class,
	];

	/**
	 * @var array<string, FeatureToggle|array{
	 *     0: array<int, array{0: class-string, 1?: array<int, mixed>}>,
	 *     1?: string
	 * }>
	 */
	private array $featureToggles;

	/**
	 * @param array<string, FeatureToggle|array{
	 *     0: array<int, array{0: class-string, 1?: array<int, mixed>}>,
	 *     1?: string
	 * }> $featureToggles
	 */
	public function __construct(array $featureToggles)
	{
		$this->featureToggles = $featureToggles;
	}

	public function hasToggle(string $key): bool
	{
		return isset($this->featureToggles[$key]);
	}

	public function get(string $key): ?FeatureToggle
	{
		if (!isset($this->featureToggles[$key])) {
			return null;
		}

		$featureToggle = $this->featureToggles[$key];
		if ($featureToggle instanceof FeatureToggle) {
			return $featureToggle;
		}

		$conditions = array_map(
			static function (array $data): ConditionInterface {
				assert(is_subclass_of($data[0], ConditionInterface::class));
				return new $data[0](...$data[1] ?? []);
			},
			$featureToggle[0]
		);
		$combination = self::COMBINATION_ALIAS[$featureToggle[1] ?? ConditionAll::class];

		$this->featureToggles[$key] = new FeatureToggle($key, new $combination(...$conditions));
		return $this->featureToggles[$key];
	}
}
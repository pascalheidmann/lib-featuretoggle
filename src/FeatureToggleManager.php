<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleNotFoundException;
use PascalHeidmann\FeatureToggle\Repository\FeatureToggleRepositoryInterface;

class FeatureToggleManager
{
	/** @var FeatureToggleRepositoryInterface[] */
	private array $featureToggleRepository;

	public function __construct(FeatureToggleRepositoryInterface ...$featureToggleRepository)
	{
		$this->featureToggleRepository = $featureToggleRepository;
	}

	public function addRepository(FeatureToggleRepositoryInterface $repository): self
	{
		$this->featureToggleRepository[] = $repository;
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	public function get(string $key, array $data = []): bool
	{
		foreach ($this->featureToggleRepository as $repository) {
			$featureToggle = $repository->get($key);

			if ($featureToggle !== null) {
				return $featureToggle->evaluate($data);
			}
		}
		throw new FeatureToggleNotFoundException($key);
	}
}
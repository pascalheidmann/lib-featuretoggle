<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleNotFoundException;
use PascalHeidmann\FeatureToggle\Repository\RepositoryInterface;

class FeatureToggleManager
{
	/** @var RepositoryInterface[] */
	private array $featureToggleRepository;

	public function __construct(RepositoryInterface ...$featureToggleRepository)
	{
		$this->featureToggleRepository = $featureToggleRepository;
	}

	public function addRepository(RepositoryInterface $repository): self
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
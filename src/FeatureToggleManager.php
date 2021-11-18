<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle;

use PascalHeidmann\FeatureToggle\Exception\FeatureToggleNotFoundException;
use PascalHeidmann\FeatureToggle\Repository\RepositoryInterface;

class FeatureToggleManager
{
	/** @var RepositoryInterface[] */
	private array $featureToggleRepository;
	/** @var array<string, mixed> */
	private array $defaultData = [];

	public function __construct(RepositoryInterface ...$featureToggleRepository)
	{
		$this->featureToggleRepository = $featureToggleRepository;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	public function addDefaultData(array $data): void
	{
		$this->defaultData = array_merge($this->defaultData, $data);
	}

	public function resetDefaultData(): void {
		$this->defaultData = [];
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
				return $featureToggle->evaluate(array_merge($this->defaultData, $data));
			}
		}
		throw new FeatureToggleNotFoundException($key);
	}
}
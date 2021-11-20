<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle;

use PascalHeidmann\FeatureToggle\Repository\RepositoryInterface;

interface FeatureToggleManagerInterface
{
	/**
	 * @param array<string, mixed> $data
	 */
	public function addDefaultData(array $data): void;

	public function resetDefaultData(): void;

	public function addRepository(RepositoryInterface $repository): FeatureToggleManagerInterface;

	/**
	 * @param array<string, mixed> $data
	 */
	public function get(string $key, array $data = []): bool;
}
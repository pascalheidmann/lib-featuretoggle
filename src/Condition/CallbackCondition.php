<?php
declare(strict_types=1);

namespace FeatureToggle\Condition;

class CallbackCondition implements ConditionInterface
{
	/** @var callable(array<string, mixed> $data): bool */
	private $callback;

	/**
	 * @param callable(array<string, mixed> $data): bool $callback
	 */
	public function __construct(callable $callback)
	{
		$this->callback = $callback;
	}

	public function evaluate(array $data = []): bool
	{
		return ($this->callback)($data);
	}
}
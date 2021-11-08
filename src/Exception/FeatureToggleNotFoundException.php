<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Exception;

use RuntimeException;

class FeatureToggleNotFoundException extends RuntimeException implements FeatureToggleException
{
	private const EXCEPTION_MESSAGE = 'Feature toggle with key "%s" not found';

	public function __construct(string $key)
	{
		parent::__construct(sprintf(self::EXCEPTION_MESSAGE, $key));
	}
}
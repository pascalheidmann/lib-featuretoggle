<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Exception;

use JetBrains\PhpStorm\Pure;
use RuntimeException;
use function sprintf;

class FeatureToggleRequiredParameterMissingException extends RuntimeException implements FeatureToggleException
{
	private const EXCEPTION_MESSAGE = 'Feature toggle "%s" requires data "%s"';

	
	public function __construct(string $key, string $data)
	{
		parent::__construct(sprintf(self::EXCEPTION_MESSAGE, $key, $data));
	}

}
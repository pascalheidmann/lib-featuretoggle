<?php
declare(strict_types=1);

namespace PascalHeidmann\FeatureToggle\Exception;

use JetBrains\PhpStorm\Pure;
use RuntimeException;

class DuplicateFeatureToggleInRepositoryException extends RuntimeException implements FeatureToggleException
{
	
	public function __construct(string $repository, string $key)
	{
		parent::__construct(sprintf('Tried to add feature toggle with key "%s" to repository "%s', $key, $repository));
	}
}
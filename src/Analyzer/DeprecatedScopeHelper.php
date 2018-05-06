<?php declare(strict_types = 1);

namespace PHPStan\Analyzer;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\DeprecatableReflection;

class DeprecatedScopeHelper
{

	public static function isScopeDeprecated(Scope $scope): bool
	{
		$class = $scope->getClassReflection();
		if ($class !== null && $class->isDeprecated()) {
			return true;
		}

		$function = $scope->getFunction();
		if ($function instanceof DeprecatableReflection && $function->isDeprecated()) {
			return true;
		}

		return false;
	}

}

<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

class BooleanRuleHelper
{

	public static function passesAsBoolean(\PHPStan\Type\Type $type): bool
	{
		if ($type instanceof \PHPStan\Type\BooleanType) {
			return true;
		}
		if (
			$type instanceof \PHPStan\Type\MixedType
			&& !$type->isExplicitMixed()
		) {
			return true;
		}

		return false;
	}

}

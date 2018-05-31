<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Type\ErrorType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;

class OperatorRuleHelper
{

	public static function isValidForArithmeticOperation(Type $type): bool
	{
		if ($type instanceof MixedType) {
			return true;
		}

		if ($type->toNumber() instanceof ErrorType) {
			return true;
		}

		$acceptedType = new UnionType([new IntegerType(), new FloatType()]);

		return $acceptedType->isSuperTypeOf($type)->yes();
	}

}

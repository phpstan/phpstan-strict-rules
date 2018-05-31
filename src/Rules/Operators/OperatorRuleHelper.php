<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node\Expr;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;

class OperatorRuleHelper
{

	/** @var \PHPStan\Rules\RuleLevelHelper */
	private $ruleLevelHelper;

	public function __construct(RuleLevelHelper $ruleLevelHelper)
	{
		$this->ruleLevelHelper = $ruleLevelHelper;
	}

	public function isValidForArithmeticOperation(Scope $scope, Expr $expr): bool
	{
		$type = $scope->getType($expr);
		if ($type instanceof MixedType) {
			return true;
		}

		if ($type->toNumber() instanceof ErrorType) {
			return true;
		}

		$acceptedType = new UnionType([new IntegerType(), new FloatType()]);

		$typeToCheck = $this->ruleLevelHelper->findTypeToCheck(
			$scope,
			$expr,
			'',
			function (Type $type) use ($acceptedType): bool {
				return $acceptedType->isSuperTypeOf($type)->yes();
			}
		);
		$type = $typeToCheck->getType();
		if ($type instanceof ErrorType) {
			return true;
		}

		return $acceptedType->isSuperTypeOf($type)->yes();
	}

}

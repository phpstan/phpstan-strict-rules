<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node\Expr;
use PHPStan\Analyser\Scope;
use PHPStan\PhpDoc\TypeStringResolver;
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

	/** @var string */
	private $allowedLooseComparison;

	/** @var Type */
	private $looseComparisonAllowedType;

	public function __construct(
		RuleLevelHelper $ruleLevelHelper,
		TypeStringResolver $typeStringResolver,
		string $allowedLooseComparison
	)
	{
		$this->ruleLevelHelper = $ruleLevelHelper;

		$this->allowedLooseComparison = $allowedLooseComparison;
		$this->looseComparisonAllowedType = $typeStringResolver->resolve($allowedLooseComparison);
	}

	public function getAllowedLooseComparison(): string
	{
		return $this->allowedLooseComparison;
	}

	public function isValidForArithmeticOperation(Scope $scope, Expr $expr): bool
	{
		$type = $scope->getType($expr);
		if ($type instanceof MixedType) {
			return true;
		}

		// already reported by PHPStan core
		if ($type->toNumber() instanceof ErrorType) {
			return true;
		}

		return $this->isSubtypeOf($scope, $expr, new UnionType([new IntegerType(), new FloatType()]));
	}

	public function isValidForIncrementOrDecrement(Scope $scope, Expr $expr): bool
	{
		$type = $scope->getType($expr);
		if ($type instanceof MixedType) {
			return true;
		}

		return $this->isSubtypeOf($scope, $expr, new UnionType([new IntegerType(), new FloatType()]));
	}

	public function isValidForLooseComparisonOperation(Scope $scope, Expr $expr): bool
	{
		$type = $scope->getType($expr);
		if ($type instanceof MixedType) {
			return true;
		}

		// already reported by PHPStan core
		if ($type->toNumber() instanceof ErrorType) {
			return true;
		}

		return $this->isSubtypeOf($scope, $expr, $this->looseComparisonAllowedType);
	}

	private function isSubtypeOf(Scope $scope, Expr $expr, Type $acceptedType): bool
	{
		$type = $this->ruleLevelHelper->findTypeToCheck(
			$scope,
			$expr,
			'',
			function (Type $type) use ($acceptedType): bool {
				return $acceptedType->isSuperTypeOf($type)->yes();
			}
		)->getType();

		if ($type instanceof ErrorType) {
			return true;
		}

		$isSuperType = $acceptedType->isSuperTypeOf($type);
		if ($type instanceof \PHPStan\Type\BenevolentUnionType) {
			return !$isSuperType->no();
		}

		return $isSuperType->yes();
	}

}

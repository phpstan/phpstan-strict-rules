<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;

class OperandsInArithmeticAddition implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\BinaryOp\Plus::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\BinaryOp\BooleanAnd $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		$leftType = $scope->getType($node->left);
		$rightType = $scope->getType($node->right);

		if (OperatorRuleHelper::isValidForArithmeticOperation($leftType, $rightType)) {
			return [];
		}

		$mixedArrayType = new ArrayType(new MixedType(), new MixedType());

		if ($mixedArrayType->isSuperTypeOf($leftType)->yes() && $mixedArrayType->isSuperTypeOf($rightType)->yes()) {
			return [];
		}

		return ['Only numeric types or arrays are allowed in arithmetic addition.'];
	}

}

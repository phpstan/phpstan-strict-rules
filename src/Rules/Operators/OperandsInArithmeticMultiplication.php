<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

class OperandsInArithmeticMultiplication implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\BinaryOp\Mul::class;
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

		return ['Only numeric types are allowed in arithmetic multiplication.'];
	}

}

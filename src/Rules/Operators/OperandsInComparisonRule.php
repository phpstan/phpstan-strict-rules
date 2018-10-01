<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\FloatType;

class OperandsInComparisonRule implements Rule
{

	public function getNodeType(): string
	{
		return BinaryOp::class;
	}

	/**
	 * @param Node $node
	 * @param Scope $scope
	 * @return string[]
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if (!$node instanceof BinaryOp\Equal
			&& !$node instanceof BinaryOp\Identical
			&& !$node instanceof BinaryOp\NotEqual
			&& !$node instanceof BinaryOp\NotIdentical
			&& !$node instanceof BinaryOp\GreaterOrEqual
			&& !$node instanceof BinaryOp\SmallerOrEqual
		) {
			return [];
		}

		$rightType = $scope->getType($node->right);
		$leftType = $scope->getType($node->left);

		if ($rightType instanceof FloatType || $leftType instanceof FloatType) {
			if ($node instanceof  BinaryOp\Equal || $node instanceof BinaryOp\Identical) {
				return [
					'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
					. 'You should use `abs($left - $right) < $epsilon`, where $epsilon is maximum allowed deviation.',
				];
			}

			if ($node instanceof  BinaryOp\NotEqual || $node instanceof BinaryOp\NotIdentical) {
				return [
					'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
					. 'You should use `abs($left - $right) >= $epsilon`, where $epsilon is maximum allowed deviation.',
				];
			}

			if ($node instanceof BinaryOp\GreaterOrEqual) {
				return [
					'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
					. 'You should use `$left - $right >= $epsilon`, where $epsilon is maximum allowed deviation.',
				];
			}

			return [
				'Exact comparison of floating-point numbers is not accurate.' . PHP_EOL
				. 'You should use `$right - $left >= $epsilon`, where $epsilon is maximum allowed deviation.',
			];
		}

		return [];
	}

}

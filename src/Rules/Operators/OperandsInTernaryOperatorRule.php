<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node;
use PhpParser\Node\Expr\Ternary;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\ConstantType;
use PHPStan\Type\VerbosityLevel;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Ternary>
 */
class OperandsInTernaryOperatorRule implements Rule
{

	public function getNodeType(): string
	{
		return Ternary::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		$ifType = $node->if === null ? $scope->getType($node->cond) : $scope->getType($node->if);
		$elseType = $scope->getType($node->else);
		if ($ifType instanceof ConstantType && $elseType instanceof ConstantType) {
			if ($ifType->equals($elseType)) {
				return [sprintf(
					'If and else parts of ternary operator are equal (%s).',
					$ifType->describe(VerbosityLevel::value())
				)];
			}
			if ($ifType instanceof ConstantBooleanType && $elseType instanceof ConstantBooleanType) {
				return $ifType->getValue()
					? ['Ternary operator is not needed. Use just condition casted to bool.']
					: ['Ternary operator is not needed. Use condition with negation operator.'];
			}
		}

		return [];
	}

}

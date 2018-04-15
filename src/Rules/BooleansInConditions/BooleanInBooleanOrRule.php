<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Type\VerbosityLevel;

class BooleanInBooleanOrRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\BinaryOp\BooleanOr::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\BinaryOp\BooleanOr $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		$leftType = $scope->getType($node->left);
		$messages = [];
		if (!BooleanRuleHelper::passesAsBoolean($leftType)) {
			$messages[] = sprintf(
				'Only booleans are allowed in ||, %s given on the left side.',
				$leftType->describe(VerbosityLevel::typeOnly())
			);
		}

		$rightType = $scope->getType($node->right);
		if (!BooleanRuleHelper::passesAsBoolean($rightType)) {
			$messages[] = sprintf(
				'Only booleans are allowed in ||, %s given on the right side.',
				$rightType->describe(VerbosityLevel::typeOnly())
			);
		}

		return $messages;
	}

}

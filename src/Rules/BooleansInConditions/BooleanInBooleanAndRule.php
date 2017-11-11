<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

class BooleanInBooleanAndRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\BinaryOp\BooleanAnd::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\BinaryOp\BooleanAnd $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		$leftType = $scope->getType($node->left);

		$messages = [];
		if (!BooleanRuleHelper::passesAsBoolean($leftType)) {
			$messages[] = sprintf(
				'Only booleans are allowed in &&, %s given on the left side.',
				$leftType->describe()
			);
		}

		$rightType = $scope->getType($node->right);
		if (!BooleanRuleHelper::passesAsBoolean($rightType)) {
			$messages[] = sprintf(
				'Only booleans are allowed in &&, %s given on the right side.',
				$rightType->describe()
			);
		}

		return $messages;
	}

}

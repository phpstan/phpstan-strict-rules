<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Type\VerbosityLevel;

class BooleanInTernaryOperatorRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\Ternary::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\Ternary $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		if ($node->if === null) {
			return []; // elvis ?:
		}

		$conditionExpressionType = $scope->getType($node->cond);
		if (BooleanRuleHelper::passesAsBoolean($conditionExpressionType)) {
			return [];
		}

		return [
			sprintf(
				'Only booleans are allowed in a ternary operator condition, %s given.',
				$conditionExpressionType->describe(VerbosityLevel::typeOnly())
			),
		];
	}

}

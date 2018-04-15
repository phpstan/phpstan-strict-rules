<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PHPStan\Type\VerbosityLevel;

class BooleanInBooleanNotRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Expr\BooleanNot::class;
	}

	/**
	 * @param \PhpParser\Node\Expr\BooleanNot $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		$expressionType = $scope->getType($node->expr);
		if (BooleanRuleHelper::passesAsBoolean($expressionType)) {
			return [];
		}

		return [
			sprintf(
				'Only booleans are allowed in a negated boolean, %s given.',
				$expressionType->describe(VerbosityLevel::typeOnly())
			),
		];
	}

}

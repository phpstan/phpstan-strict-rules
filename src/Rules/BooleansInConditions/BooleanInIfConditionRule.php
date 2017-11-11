<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

class BooleanInIfConditionRule implements \PHPStan\Rules\Rule
{

	public function getNodeType(): string
	{
		return \PhpParser\Node\Stmt\If_::class;
	}

	/**
	 * @param \PhpParser\Node\Stmt\If_ $node
	 * @param \PHPStan\Analyser\Scope $scope
	 * @return string[] errors
	 */
	public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope): array
	{
		$conditionExpressionType = $scope->getType($node->cond);
		if (BooleanRuleHelper::passesAsBoolean($conditionExpressionType)) {
			return [];
		}

		return [
			sprintf(
				'Only booleans are allowed in an if condition, %s given.',
				$conditionExpressionType->describe()
			),
		];
	}

}

<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PhpParser\Node;
use PhpParser\Node\Stmt\ElseIf_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

class BooleanInElseIfConditionRule implements Rule
{

	/** @var BooleanRuleHelper */
	private $helper;

	public function __construct(BooleanRuleHelper $helper)
	{
		$this->helper = $helper;
	}

	public function getNodeType(): string
	{
		return ElseIf_::class;
	}

	/**
	 * @param ElseIf_ $node
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if ($this->helper->passesAsBoolean($scope, $node->cond)) {
			return [];
		}

		$conditionExpressionType = $scope->getType($node->cond);

		return [
			sprintf(
				'Only booleans are allowed in an elseif condition, %s given.',
				$conditionExpressionType->describe(VerbosityLevel::typeOnly())
			),
		];
	}

}

<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PhpParser\Node;
use PhpParser\Node\Expr\BooleanNot;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

class BooleanInBooleanNotRule implements Rule
{

	/** @var BooleanRuleHelper */
	private $helper;

	public function __construct(BooleanRuleHelper $helper)
	{
		$this->helper = $helper;
	}

	public function getNodeType(): string
	{
		return BooleanNot::class;
	}

	/**
	 * @param BooleanNot $node
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		if ($this->helper->passesAsBoolean($scope, $node->expr)) {
			return [];
		}

		$expressionType = $scope->getType($node->expr);

		return [
			sprintf(
				'Only booleans are allowed in a negated boolean, %s given.',
				$expressionType->describe(VerbosityLevel::typeOnly())
			),
		];
	}

}

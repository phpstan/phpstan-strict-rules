<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\LogicalXor;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

/**
 * @implements Rule<LogicalXor>
 */
class BooleanInBooleanXorRule implements Rule
{

	private BooleanRuleHelper $helper;

	public function __construct(BooleanRuleHelper $helper)
	{
		$this->helper = $helper;
	}

	public function getNodeType(): string
	{
		return LogicalXor::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		$messages = [];
		if (!$this->helper->passesAsBoolean($scope, $node->left)) {
			$leftType = $scope->getType($node->left);
			$messages[] = RuleErrorBuilder::message(sprintf(
				'Only booleans are allowed in %s, %s given on the left side.',
				$node->getOperatorSigil(),
				$leftType->describe(VerbosityLevel::typeOnly()),
			))->identifier('logicalXor.leftNotBoolean')->build();
		}

		if (!$this->helper->passesAsBoolean($scope, $node->right)) {
			$rightType = $scope->getType($node->right);
			$messages[] = RuleErrorBuilder::message(sprintf(
				'Only booleans are allowed in %s, %s given on the right side.',
				$node->getOperatorSigil(),
				$rightType->describe(VerbosityLevel::typeOnly()),
			))->identifier('logicalXor.rightNotBoolean')->build();
		}

		return $messages;
	}

}

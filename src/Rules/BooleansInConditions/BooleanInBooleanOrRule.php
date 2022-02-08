<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\BooleanOrNode;
use PHPStan\Rules\Rule;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

/**
 * @implements Rule<BooleanOrNode>
 */
class BooleanInBooleanOrRule implements Rule
{

	/** @var BooleanRuleHelper */
	private $helper;

	public function __construct(BooleanRuleHelper $helper)
	{
		$this->helper = $helper;
	}

	public function getNodeType(): string
	{
		return BooleanOrNode::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		$originalNode = $node->getOriginalNode();
		$messages = [];
		if (!$this->helper->passesAsBoolean($scope, $originalNode->left)) {
			$leftType = $scope->getType($originalNode->left);
			$messages[] = sprintf(
				'Only booleans are allowed in ||, %s given on the left side.',
				$leftType->describe(VerbosityLevel::typeOnly())
			);
		}

		$rightScope = $node->getRightScope();
		if (!$this->helper->passesAsBoolean($rightScope, $originalNode->right)) {
			$rightType = $rightScope->getType($originalNode->right);
			$messages[] = sprintf(
				'Only booleans are allowed in ||, %s given on the right side.',
				$rightType->describe(VerbosityLevel::typeOnly())
			);
		}

		return $messages;
	}

}

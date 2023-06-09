<?php declare(strict_types = 1);

namespace PHPStan\Rules\BooleansInConditions;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\BooleanOrNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

/**
 * @implements Rule<BooleanOrNode>
 */
class BooleanInBooleanOrRule implements Rule
{

	/** @var BooleanRuleHelper */
	private $helper;

	/** @var bool */
	private $bleedingEdge;

	public function __construct(BooleanRuleHelper $helper, bool $bleedingEdge)
	{
		$this->helper = $helper;
		$this->bleedingEdge = $bleedingEdge;
	}

	public function getNodeType(): string
	{
		return BooleanOrNode::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		$originalNode = $node->getOriginalNode();
		$messages = [];
		$nodeText = $this->bleedingEdge ? $originalNode->getOperatorSigil() : '||';
		$identifierType = $originalNode instanceof Node\Expr\BinaryOp\BooleanOr ? 'booleanOr' : 'logicalOr';
		if (!$this->helper->passesAsBoolean($scope, $originalNode->left)) {
			$leftType = $scope->getType($originalNode->left);
			$messages[] = RuleErrorBuilder::message(sprintf(
				'Only booleans are allowed in %s, %s given on the left side.',
				$nodeText,
				$leftType->describe(VerbosityLevel::typeOnly())
			))->identifier(sprintf('%s.leftNotBoolean', $identifierType))->build();
		}

		$rightScope = $node->getRightScope();
		if (!$this->helper->passesAsBoolean($rightScope, $originalNode->right)) {
			$rightType = $rightScope->getType($originalNode->right);
			$messages[] = RuleErrorBuilder::message(sprintf(
				'Only booleans are allowed in %s, %s given on the right side.',
				$nodeText,
				$rightType->describe(VerbosityLevel::typeOnly())
			))->identifier(sprintf('%s.rightNotBoolean', $identifierType))->build();
		}

		return $messages;
	}

}

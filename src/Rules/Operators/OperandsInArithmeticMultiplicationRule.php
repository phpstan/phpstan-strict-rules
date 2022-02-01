<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\Mul;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

class OperandsInArithmeticMultiplicationRule implements Rule
{

	/** @var OperatorRuleHelper */
	private $helper;

	public function __construct(OperatorRuleHelper $helper)
	{
		$this->helper = $helper;
	}

	public function getNodeType(): string
	{
		return Mul::class;
	}

	/**
	 * @param BooleanAnd $node
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		$messages = [];
		$leftType = $scope->getType($node->left);
		if (!$this->helper->isValidForArithmeticOperation($scope, $node->left)) {
			$messages[] = sprintf(
				'Only numeric types are allowed in *, %s given on the left side.',
				$leftType->describe(VerbosityLevel::typeOnly())
			);
		}

		$rightType = $scope->getType($node->right);
		if (!$this->helper->isValidForArithmeticOperation($scope, $node->right)) {
			$messages[] = sprintf(
				'Only numeric types are allowed in *, %s given on the right side.',
				$rightType->describe(VerbosityLevel::typeOnly())
			);
		}

		return $messages;
	}

}

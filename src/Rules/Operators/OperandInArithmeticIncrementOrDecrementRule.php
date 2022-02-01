<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node;
use PhpParser\Node\Expr\PostDec;
use PhpParser\Node\Expr\PostInc;
use PhpParser\Node\Expr\PreDec;
use PhpParser\Node\Expr\PreInc;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\VerbosityLevel;
use function sprintf;

abstract class OperandInArithmeticIncrementOrDecrementRule implements Rule
{

	/** @var OperatorRuleHelper */
	private $helper;

	public function __construct(OperatorRuleHelper $helper)
	{
		$this->helper = $helper;
	}

	/**
	 * @param PreInc|PreDec|PostInc|PostDec $node
	 * @return string[] errors
	 */
	public function processNode(Node $node, Scope $scope): array
	{
		$messages = [];
		$varType = $scope->getType($node->var);

		if (!$this->helper->isValidForIncrementOrDecrement($scope, $node->var)) {
			$messages[] = sprintf(
				'Only numeric types are allowed in %s, %s given.',
				$this->describeOperation(),
				$varType->describe(VerbosityLevel::typeOnly())
			);
		}

		return $messages;
	}

	abstract protected function describeOperation(): string;

}

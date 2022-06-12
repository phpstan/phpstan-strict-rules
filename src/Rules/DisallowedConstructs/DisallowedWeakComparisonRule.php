<?php declare(strict_types = 1);

namespace PHPStan\Rules\DisallowedConstructs;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<BinaryOp>
 */
class DisallowedWeakComparisonRule implements Rule
{

	public function getNodeType(): string
	{
		return BinaryOp::class;
	}

	public function processNode(Node $node, Scope $scope): array
	{
		if ($node instanceof Equal || $node instanceof NotEqual) {
			return [
				'Weak comparison via "' . $node->getOperatorSigil() . '" is not allowed. Use strong comparison.',
			];
		} else {
			return [];
		}
	}

}

<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node\Expr\PreInc;

class OperandInArithmeticPreIncrementRule extends OperandInArithmeticIncrementOrDecrementRule
{

	public function getNodeType(): string
	{
		return PreInc::class;
	}

	protected function describeOperation(): string
	{
		return 'pre-increment';
	}

}

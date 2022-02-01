<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node\Expr\PreDec;

class OperandInArithmeticPreDecrementRule extends OperandInArithmeticIncrementOrDecrementRule
{

	public function getNodeType(): string
	{
		return PreDec::class;
	}

	protected function describeOperation(): string
	{
		return 'pre-decrement';
	}

}

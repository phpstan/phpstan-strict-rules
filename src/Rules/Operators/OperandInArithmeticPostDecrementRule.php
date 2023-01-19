<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node\Expr\PostDec;

class OperandInArithmeticPostDecrementRule extends OperandInArithmeticDecrementRule
{

	public function getNodeType(): string
	{
		return PostDec::class;
	}

	protected function describeOperation(): string
	{
		return 'post-decrement';
	}

}

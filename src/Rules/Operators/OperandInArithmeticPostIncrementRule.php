<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PhpParser\Node\Expr\PostInc;

class OperandInArithmeticPostIncrementRule extends OperandInArithmeticIncrementRule
{

	public function getNodeType(): string
	{
		return PostInc::class;
	}

	protected function describeOperation(): string
	{
		return 'post-increment';
	}

}

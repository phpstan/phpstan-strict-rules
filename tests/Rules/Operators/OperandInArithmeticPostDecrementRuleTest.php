<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandInArithmeticPostDecrementRuleTest extends OperandInArithmeticIncrementOrDecrementRuleTest
{

	protected function createRule(OperatorRuleHelper $helper): Rule
	{
		return new OperandInArithmeticPostDecrementRule($helper);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getExpectedErrors(): array
	{
		return [
			[
				'Only numeric types are allowed in post-decrement, false given.',
				21,
			],
			[
				'Only numeric types are allowed in post-decrement, string given.',
				22,
			],
			[
				'Only numeric types are allowed in post-decrement, null given.',
				23,
			],
			[
				'Only numeric types are allowed in post-decrement, stdClass given.',
				24,
			],
			[
				'Only numeric types are allowed in post-decrement, int|stdClass|string given.',
				26,
			],
		];
	}

}

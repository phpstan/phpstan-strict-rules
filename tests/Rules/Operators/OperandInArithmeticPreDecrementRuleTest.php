<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

/**
 * @extends OperandInArithmeticIncrementOrDecrementRuleTestCase<OperandInArithmeticPreDecrementRule>
 */
class OperandInArithmeticPreDecrementRuleTest extends OperandInArithmeticIncrementOrDecrementRuleTestCase
{

	protected function createRule(OperatorRuleHelper $helper): Rule
	{
		return new OperandInArithmeticPreDecrementRule($helper);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getExpectedErrors(): array
	{
		return [
			[
				'Only numeric types are allowed in pre-decrement, false given.',
				43,
			],
			[
				'Only numeric types are allowed in pre-decrement, string given.',
				44,
			],
			[
				'Only numeric types are allowed in pre-decrement, null given.',
				45,
			],
			[
				'Only numeric types are allowed in pre-decrement, stdClass given.',
				46,
			],
			[
				'Only numeric types are allowed in pre-decrement, int|stdClass|string given.',
				48,
			],
		];
	}

}

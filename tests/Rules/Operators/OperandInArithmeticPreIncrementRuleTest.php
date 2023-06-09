<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

/**
 * @extends OperandInArithmeticIncrementOrDecrementRuleTestCase<OperandInArithmeticPreIncrementRule>
 */
class OperandInArithmeticPreIncrementRuleTest extends OperandInArithmeticIncrementOrDecrementRuleTestCase
{

	protected function createRule(OperatorRuleHelper $helper): Rule
	{
		return new OperandInArithmeticPreIncrementRule($helper);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getExpectedErrors(): array
	{
		return [
			[
				'Only numeric types are allowed in pre-increment, false given.',
				54,
			],
			[
				'Only numeric types are allowed in pre-increment, null given.',
				56,
			],
			[
				'Only numeric types are allowed in pre-increment, stdClass given.',
				57,
			],
			[
				'Only numeric types are allowed in pre-increment, int|stdClass|string given.',
				59,
			],
		];
	}

}

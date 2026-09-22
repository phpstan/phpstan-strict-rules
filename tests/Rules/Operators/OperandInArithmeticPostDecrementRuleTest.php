<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

/**
 * @extends OperandInArithmeticIncrementOrDecrementRuleTestCase<OperandInArithmeticPostDecrementRule>
 */
class OperandInArithmeticPostDecrementRuleTest extends OperandInArithmeticIncrementOrDecrementRuleTestCase
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
				25,
			],
			[
				'Only numeric types are allowed in post-decrement, string given.',
				26,
			],
			[
				'Only numeric types are allowed in post-decrement, null given.',
				27,
			],
			[
				'Only numeric types are allowed in post-decrement, stdClass given.',
				28,
			],
			[
				'Only numeric types are allowed in post-decrement, int|stdClass|string given.',
				30,
			],
		];
	}

}

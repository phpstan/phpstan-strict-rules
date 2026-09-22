<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

/**
 * @extends OperandInArithmeticIncrementOrDecrementRuleTestCase<OperandInArithmeticPostIncrementRule>
 */
class OperandInArithmeticPostIncrementRuleTest extends OperandInArithmeticIncrementOrDecrementRuleTestCase
{

	protected function createRule(OperatorRuleHelper $helper): Rule
	{
		return new OperandInArithmeticPostIncrementRule($helper);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getExpectedErrors(): array
	{
		return [
			[
				'Only numeric types are allowed in post-increment, false given.',
				38,
			],
			[
				'Only numeric types are allowed in post-increment, null given.',
				40,
			],
			[
				'Only numeric types are allowed in post-increment, stdClass given.',
				41,
			],
			[
				'Only numeric types are allowed in post-increment, int|stdClass|string given.',
				43,
			],
		];
	}

}

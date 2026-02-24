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
				32,
			],
			[
				'Only numeric types are allowed in post-increment, null given.',
				34,
			],
			[
				'Only numeric types are allowed in post-increment, stdClass given.',
				35,
			],
			[
				'Only numeric types are allowed in post-increment, int|stdClass|string given.',
				37,
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getExpectedErrorsWithBcMath(): array
	{
		return [
			[
				'Only numeric types are allowed in post-increment, BcMath\Number given.',
				12,
			],
		];
	}

}

<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInArithmeticMultiplicationRuleTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticMultiplicationRule();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in arithmetic multiplication.',
				51,
			],
			[
				'Only numeric types are allowed in arithmetic multiplication.',
				52,
			],
			[
				'Only numeric types are allowed in arithmetic multiplication.',
				53,
			],
			[
				'Only numeric types are allowed in arithmetic multiplication.',
				54,
			],
			[
				'Only numeric types are allowed in arithmetic multiplication.',
				55,
			],
			[
				'Only numeric types are allowed in arithmetic multiplication.',
				55,
			],
			[
				'Only numeric types are allowed in arithmetic multiplication.',
				56,
			],
		]);
	}

}

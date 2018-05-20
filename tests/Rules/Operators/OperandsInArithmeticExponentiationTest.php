<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInArithmeticExponentiationTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticExponentiation();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in arithmetic exponentiation.',
				77,
			],
			[
				'Only numeric types are allowed in arithmetic exponentiation.',
				78,
			],
			[
				'Only numeric types are allowed in arithmetic exponentiation.',
				79,
			],
			[
				'Only numeric types are allowed in arithmetic exponentiation.',
				80,
			],
			[
				'Only numeric types are allowed in arithmetic exponentiation.',
				81,
			],
			[
				'Only numeric types are allowed in arithmetic exponentiation.',
				82,
			],
			[
				'Only numeric types are allowed in arithmetic exponentiation.',
				82,
			],
		]);
	}

}

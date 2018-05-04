<?php declare(strict_types = 1);

namespace PHPStan\Rules\Operators;

use PHPStan\Rules\Rule;

class OperandsInArithmeticSubtractionTest extends \PHPStan\Testing\RuleTestCase
{

	protected function getRule(): Rule
	{
		return new OperandsInArithmeticSubtraction();
	}

	public function testRule(): void
	{
		$this->analyse([__DIR__ . '/data/operators.php'], [
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				38,
			],
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				39,
			],
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				40,
			],
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				41,
			],
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				42,
			],
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				42,
			],
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				43,
			],
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				43,
			],
			[
				'Only numeric types are allowed in arithmetic subtraction.',
				43,
			],
		]);
	}

}
